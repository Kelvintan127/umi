import { chromium } from "playwright";
import { mkdirSync, writeFileSync } from "node:fs";

const base="http://127.0.0.1:8000";
const browser=await chromium.launch({headless:true});
mkdirSync("visual-qa/media",{recursive:true});
const results=[];
const record=(check,pass,info={})=>results.push({check,pass:Boolean(pass),...info});
try {
  for(const [name,width,height] of [["desktop-1440",1440,900],["mobile-390",390,844]]) {
    const context=await browser.newContext({viewport:{width,height},reducedMotion:"reduce"});
    const page=await context.newPage();
    await page.goto(base+"/en",{waitUntil:"domcontentloaded"});
    await page.evaluate(()=>document.fonts.ready);
    const media=await page.evaluate(()=>{
      const hero=document.querySelector('img[src="/images/hero/precision-metal-component.webp"]');
      const cards=Array.from(document.querySelectorAll('#umi-products article img'));
      const favicon=document.querySelector('link[rel="icon"]');
      return {hero:hero?{src:hero.getAttribute("src"),width:hero.naturalWidth,height:hero.naturalHeight,loaded:hero.complete}:null,
        cards:cards.map(x=>({src:x.getAttribute("src"),loaded:x.complete,width:x.naturalWidth,height:x.naturalHeight})),
        favicon:favicon?.getAttribute("href"),
        oldScreenshotsInCards:!!document.querySelector('#umi-products article svg[role="img"]'),
        failedImgs:Array.from(document.images).filter(x=>x.loading!=="lazy"&&x.complete&&x.naturalWidth===0).map(x=>x.src),
      };
    });
    record(name+": hero has original 1400px source",media.hero?.width===1400&&media.hero.height===933,media);
    record(name+": favicon links real UMI logo",media.favicon==="/images/logo.png");
    const iconRequest=await page.request.get(base+"/images/logo.png");
    record(name+": favicon image loads",iconRequest.ok()&&iconRequest.headers()["content-type"]?.includes("image/png"));
    record(name+": product cards render source images not mockup fragments",media.cards.length===4&&!media.oldScreenshotsInCards&&media.cards.every(c=>c.src?.startsWith("/images/products/")));
    await page.locator("#umi-products").scrollIntoViewIfNeeded();
    await page.waitForTimeout(180);
    const loaded=await page.locator("#umi-products article img").evaluateAll(nodes=>nodes.map(x=>({width:x.naturalWidth,height:x.naturalHeight,complete:x.complete})));
    record(name+": product source images load",loaded.length===4&&loaded.every(x=>x.width>0&&x.complete),{loaded});
    await page.screenshot({path:"visual-qa/media/home-"+name+".png",fullPage:true,animations:"disabled"});
    await context.close();
  }
  const context=await browser.newContext({viewport:{width:1440,height:900}});
  const page=await context.newPage();
  await page.goto(base+"/en/facilities",{waitUntil:"domcontentloaded"});
  await page.locator(".umi-interior-facility-list img").first().scrollIntoViewIfNeeded();
  const actual=await page.locator(".umi-interior-facility-list img").first().evaluate(img=>({width:img.naturalWidth,src:img.getAttribute("src")}));
  record("Facilities inner page uses real verified original machine file",actual.src?.startsWith("/images/facilities/")&&actual.width>0,{actual});
  await context.close();
} finally {await browser.close();}
const failures=results.filter(x=>!x.pass);
writeFileSync("visual-qa/media/report.json",JSON.stringify({results,failures},null,2));
console.log("Media QA",JSON.stringify({total:results.length,passed:results.length-failures.length,failed:failures.length},null,2));
if(failures.length)process.exitCode=1;
