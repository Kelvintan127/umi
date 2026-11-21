import { chromium } from "playwright";
import { mkdirSync, writeFileSync } from "node:fs";
const report = { commit:process.env.GITHUB_SHA, checks:[], failed:[] };
mkdirSync("visual-qa/motion", { recursive:true });
const browser = await chromium.launch({ headless:true });
const base = "http://127.0.0.1:8000";
const record = (name,pass,details={}) => {
  const item={name,pass:!!pass,...details};
  report.checks.push(item);
  if(!pass) report.failed.push(item);
};
try {
  const context=await browser.newContext({ viewport:{width:1440,height:900}, reducedMotion:"no-preference" });
  const page=await context.newPage();
  await page.goto(base+"/en",{waitUntil:"domcontentloaded"});
  await page.evaluate(()=>{
    window.__umiPersist="same-window";
    window.__umiTransitions=0;
    const native=document.startViewTransition?.bind(document);
    if(native) document.startViewTransition=(callback)=>{
      window.__umiTransitions+=1;
      return native(callback);
    };
  });
  const supportsNative=await page.evaluate(()=>typeof document.startViewTransition==="function");
  await page.locator('header nav a[href="/en/about"]').first().click();
  await page.waitForURL("**/en/about");
  await page.locator(".umi-interior-hero").waitFor();
  const nav=await page.evaluate(()=>({
    sameWindow:window.__umiPersist==="same-window",
    transitions:window.__umiTransitions??0,
  }));
  record("Inertia GET keeps SPA context",nav.sameWindow,nav);
  record("native transition for GET",!supportsNative||nav.transitions>0,nav);

  const response=await page.goto(base+"/en/contact",{waitUntil:"domcontentloaded"});
  await page.locator("main").waitFor();
  const contact=await page.evaluate(()=>({
    obsolete:/jakarta|jababeka|sales office/i.test(document.body.innerText),
    batam:document.body.innerText.includes("Batam"),
    officeTab:!!document.querySelector('[aria-label="Office locations"]'),
    mapButton:Array.from(document.querySelectorAll("button")).filter(b=>/Explore interactive map/i.test(b.textContent??"")).length,
  }));
  record("Batam is the only advertised location",response?.status()===200&&!contact.obsolete&&contact.batam&&!contact.officeTab&&contact.mapButton===1,contact);
  await page.getByRole("button",{name:"Explore interactive map"}).click();
  record("interactive Batam map remains available",(await page.locator('iframe[title="Interactive Batam factory location map"]').count())===1);
  await page.screenshot({path:"visual-qa/motion/contact-batam-only.png",fullPage:true,animations:"disabled"});
  await context.close();

  const mobile=await browser.newContext({viewport:{width:390,height:844},reducedMotion:"no-preference"});
  const mp=await mobile.newPage();
  await mp.goto(base+"/en",{waitUntil:"domcontentloaded"});
  const toggle=mp.locator('button[aria-controls="umi-mobile-nav"]');
  await toggle.click();
  record("mobile menu opens",await mp.locator("#umi-mobile-nav").getAttribute("aria-hidden")==="false");
  await mp.keyboard.press("Escape");
  record("mobile menu closes by Escape",await mp.locator("#umi-mobile-nav").getAttribute("aria-hidden")==="true");
  await mp.screenshot({path:"visual-qa/motion/mobile-menu-closed.png",animations:"disabled"});
  await mobile.close();

  const reduced=await browser.newContext({viewport:{width:1440,height:900},reducedMotion:"reduce"});
  const rp=await reduced.newPage();
  await rp.goto(base+"/en",{waitUntil:"domcontentloaded"});
  await rp.evaluate(()=>{
    window.__umiTransitions=0;
    const native=document.startViewTransition?.bind(document);
    if(native) document.startViewTransition=(callback)=>{
      window.__umiTransitions+=1;
      return native(callback);
    };
  });
  await rp.locator('header nav a[href="/en/about"]').first().click();
  await rp.waitForURL("**/en/about");
  record("reduced motion disables page transition",await rp.evaluate(()=>window.__umiTransitions===0));
  await reduced.close();
} finally {await browser.close();}
writeFileSync("visual-qa/motion/report.json",JSON.stringify(report,null,2));
console.log("Motion QA",JSON.stringify({passed:report.checks.length-report.failed.length,failed:report.failed},null,2));
if(report.failed.length)process.exitCode=1;
