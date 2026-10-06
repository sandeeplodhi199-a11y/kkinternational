@extends('backend.layouts.app')

@section('content')
@php
    $user      = Auth::user();
    $isTeacher = $user->type === 'teacher';
@endphp

{{-- ══════════════════════════════════════════════════
     HISAB MITTRA CRM & ERP DASHBOARD
     Database: hisabmittra_crm
══════════════════════════════════════════════════ --}}

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ═══════════════════════ ROOT VARIABLES ═══════════════════════ */
:root {
  --font: 'Plus Jakarta Sans', sans-serif;
  --mono: 'Space Mono', monospace;
  --bg:       #f0f2f8;
  --surface:  #ffffff;
  --surface2: #f7f8fc;
  --border:   #e2e8f4;
  --border2:  #eceff8;
  --text1: #0a1628;
  --text2: #4a5568;
  --text3: #94a3b8;
  --indigo:   #4338ca; --indigo-l: #eef2ff; --indigo-s: #c7d2fe;
  --blue:     #1d4ed8; --blue-l:   #eff6ff; --blue-s:   #bfdbfe;
  --sky:      #0284c7; --sky-l:    #f0f9ff;
  --emerald:  #047857; --emerald-l:#ecfdf5; --emerald-s:#a7f3d0;
  --teal:     #0d9488; --teal-l:   #f0fdfa;
  --violet:   #6d28d9; --violet-l: #ede9fe; --violet-s: #c4b5fd;
  --amber:    #b45309; --amber-l:  #fffbeb; --amber-s:  #fde68a;
  --orange:   #c2410c; --orange-l: #fff7ed; --orange-s: #fed7aa;
  --rose:     #be123c; --rose-l:   #fff1f2; --rose-s:   #fecdd3;
  --pink:     #9d174d; --pink-l:   #fdf2f8;
  --cyan:     #0e7490; --cyan-l:   #ecfeff;
  --c1:#4338ca; --c2:#047857; --c3:#be123c;
  --c4:#b45309; --c5:#0d9488; --c6:#6d28d9; --c7:#0284c7; --c8:#9d174d;
  --sh-xs: 0 1px 3px rgba(10,22,40,.06);
  --sh-sm: 0 2px 10px rgba(10,22,40,.08);
  --sh-md: 0 6px 22px rgba(10,22,40,.11);
  --sh-lg: 0 16px 45px rgba(10,22,40,.14);
  --sh-xl: 0 30px 80px rgba(10,22,40,.18);
  --r-xs:4px; --r-sm:8px; --r-md:12px; --r-lg:18px; --r-xl:24px;
  --ease: cubic-bezier(.4,0,.2,1);
  --spring: cubic-bezier(.34,1.56,.64,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
.erpd{background:var(--bg);font-family:var(--font);color:var(--text1);min-height:100vh;-webkit-font-smoothing:antialiased;}

/* ═══════════════════════ KEYFRAMES ═══════════════════════ */
@keyframes fadeUp   {from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}
@keyframes popIn    {from{opacity:0;transform:scale(.9)}to{opacity:1;transform:none}}
@keyframes barGrow  {from{width:0}}
@keyframes pulse2   {0%,100%{opacity:1}50%{opacity:.4}}
@keyframes float    {0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
@keyframes countUp  {from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}

/* ═══════════════════════ HEADER ═══════════════════════ */
.erp-header{
  background:linear-gradient(130deg,#050e24 0%,#0c1e50 40%,#1a3a8a 70%,#1e40af 100%);
  padding:0 28px;position:relative;overflow:hidden;
  border-bottom:1px solid rgba(255,255,255,.08);
}
.erp-header::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background:
    radial-gradient(ellipse 70% 100% at 90% 20%,rgba(99,102,241,.25) 0%,transparent 55%),
    radial-gradient(ellipse 50% 80% at 10% 80%,rgba(5,150,105,.15) 0%,transparent 55%);
}
.hdr-geo{position:absolute;inset:0;pointer-events:none;overflow:hidden;}
.hdr-geo .circle{position:absolute;border-radius:50%;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);}
.hdr-geo .c1{width:300px;height:300px;top:-100px;right:8%;animation:float 8s ease-in-out infinite;}
.hdr-geo .c2{width:160px;height:160px;bottom:-60px;right:28%;animation:float 10s ease-in-out infinite .5s;}
.hdr-geo .c3{width:80px;height:80px;top:20px;left:35%;animation:float 6s ease-in-out infinite 1s;}
.hdr-top{position:relative;z-index:10;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;padding:16px 0 0;}
.hdr-brand{display:flex;align-items:center;gap:14px;}
.brand-avatar{width:52px;height:52px;border-radius:var(--r-md);background:linear-gradient(135deg,#4338ca,#0284c7);display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff;flex-shrink:0;box-shadow:0 4px 20px rgba(67,56,202,.5);}
.brand-text h1{font-size:22px;font-weight:800;color:#fff;letter-spacing:-.5px;line-height:1.1;margin:0;}
.brand-text .sub{font-size:12px;color:rgba(255,255,255,.5);margin-top:3px;font-weight:400;}
.clock-box{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:var(--r-md);padding:12px 18px;display:flex;align-items:center;gap:16px;backdrop-filter:blur(16px);}
.clock-digits{font-family:var(--mono);font-size:22px;font-weight:700;color:#fff;letter-spacing:2px;line-height:1;}
.clock-digits .sep{animation:pulse2 1s ease infinite;display:inline-block;}
.clock-meta{display:flex;flex-direction:column;gap:2px;}
.clock-day{font-size:10px;font-weight:700;color:rgba(255,255,255,.7);text-transform:uppercase;letter-spacing:1px;}
.clock-date{font-size:11px;color:rgba(255,255,255,.45);}
.hdr-search{position:relative;display:flex;align-items:center;min-width:250px;background:rgba(255,255,255,.09);border:1.5px solid rgba(255,255,255,.15);border-radius:var(--r-md);overflow:visible;transition:all .25s;}
.hdr-search:focus-within{background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.35);}
.hdr-search .si{padding:0 12px;color:rgba(255,255,255,.5);font-size:14px;flex-shrink:0;}
.hdr-search input{flex:1;background:transparent;border:0;outline:0;color:#fff;font-size:13px;font-family:var(--font);padding:11px 0;}
.hdr-search input::placeholder{color:rgba(255,255,255,.35);}
.hdr-search .mic{background:rgba(67,56,202,.8);border:0;color:#fff;width:36px;height:36px;margin:3px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:12px;flex-shrink:0;transition:all .2s;}
.hdr-search .mic:hover{background:var(--indigo);}
.srch-drop{display:none;position:absolute;top:calc(100%+8px);left:0;right:0;background:#fff;border:1px solid var(--border);border-radius:var(--r-md);box-shadow:var(--sh-xl);z-index:999;overflow:hidden;max-height:320px;overflow-y:auto;}
.sdrop-item{display:flex;align-items:center;gap:10px;padding:10px 14px;cursor:pointer;border-bottom:1px solid var(--border2);transition:background .15s;}
.sdrop-item:hover{background:var(--indigo-l);}
.sdrop-item:last-child{border-bottom:0;}
.sdrop-tag{font-size:10px;font-weight:800;padding:2px 9px;border-radius:999px;flex-shrink:0;}
.sdrop-tag.st{background:var(--blue-s);color:var(--blue);}
.sdrop-tag.tc{background:var(--emerald-s);color:var(--emerald);}
.sdrop-name{font-size:13px;font-weight:600;color:var(--text1);}
.sess-pill{display:flex;align-items:center;gap:8px;background:rgba(4,120,87,.25);border:1px solid rgba(4,120,87,.4);border-radius:var(--r-md);padding:10px 16px;color:#fff;font-size:12px;font-weight:700;white-space:nowrap;}
.sess-pill i{color:#6ee7b7;}
.hdr-nav{display:flex;gap:2px;padding-top:20px;position:relative;z-index:10;}
.hnav-tab{padding:11px 22px;font-size:13px;font-weight:700;color:rgba(255,255,255,.45);cursor:pointer;border-radius:var(--r-sm) var(--r-sm) 0 0;transition:all .2s;border:1px solid transparent;border-bottom:0;display:flex;align-items:center;gap:8px;user-select:none;}
.hnav-tab i{font-size:12px;}
.hnav-tab:hover{color:rgba(255,255,255,.8);background:rgba(255,255,255,.07);}
.hnav-tab.active{color:var(--text1);background:var(--bg);border-color:var(--border);border-bottom-color:var(--bg);}

/* ═══════════════════════ BODY ═══════════════════════ */
.erp-body{padding:24px 28px 40px;}
.tab-pane{display:none;animation:fadeUp .35s var(--ease) both;}
.tab-pane.active{display:block;}

/* ═══════════════════════ TODAY PULSE BANNER ═══════════════════════ */
.pulse-banner{
  background:linear-gradient(125deg,#0c1e50 0%,#1a3a8a 45%,#4338ca 80%,#6d28d9 100%);
  border-radius:var(--r-xl);padding:22px 28px;display:flex;align-items:center;
  justify-content:space-between;gap:20px;flex-wrap:wrap;position:relative;overflow:hidden;
  margin-bottom:24px;box-shadow:0 12px 40px rgba(67,56,202,.35);animation:fadeUp .4s var(--ease) both;
}
.pb-deco{position:absolute;pointer-events:none;}
.pb-deco-1{top:-80px;right:-80px;width:280px;height:280px;border-radius:50%;background:rgba(255,255,255,.05);}
.pb-deco-2{bottom:-60px;left:30%;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.04);}
.pb-left{position:relative;z-index:2;}
.pb-left h3{font-size:20px;font-weight:800;color:#fff;margin-bottom:5px;display:flex;align-items:center;gap:10px;}
.pb-live{display:inline-flex;align-items:center;gap:5px;font-size:10px;font-weight:800;color:#6ee7b7;letter-spacing:.8px;text-transform:uppercase;background:rgba(4,120,87,.3);border:1px solid rgba(4,120,87,.5);border-radius:999px;padding:3px 9px;}
.pb-live::before{content:'';width:6px;height:6px;border-radius:50%;background:#6ee7b7;animation:pulse2 1.5s ease infinite;flex-shrink:0;}
.pb-left p{font-size:13px;color:rgba(255,255,255,.6);}
.pb-pills{display:flex;gap:12px;flex-wrap:wrap;position:relative;z-index:2;}
.pb-pill{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);border-radius:var(--r-md);padding:14px 20px;text-align:center;backdrop-filter:blur(12px);min-width:100px;cursor:default;transition:all .2s;}
.pb-pill:hover{background:rgba(255,255,255,.2);transform:translateY(-3px);}
.pb-pill .pv{font-size:28px;font-weight:900;color:#fff;line-height:1;font-family:var(--mono);}
.pb-pill .pl{font-size:10px;font-weight:700;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.6px;margin-top:5px;}

/* ═══════════════════════ METRIC CARDS ═══════════════════════ */
.mc4{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:22px;}
.mc8{display:grid;grid-template-columns:repeat(8,1fr);gap:12px;margin-bottom:22px;}

.bcard{background:#f0efff;border:1px solid var(--border);border-radius:var(--r-xl);padding:24px;text-decoration:none;color:inherit;display:block;position:relative;overflow:hidden;box-shadow:var(--sh-xs);transition:transform .25s var(--spring),box-shadow .25s;}
.bcard:hover{transform:translateY(-5px) scale(1.01);box-shadow:var(--sh-lg);color:inherit;text-decoration:none;}
.bcard::before{content:'';position:absolute;top:0;left:0;right:0;height:3.5px;border-radius:var(--r-xl) var(--r-xl) 0 0;}
.bcard.bc-indigo::before{background:linear-gradient(90deg,#4338ca,#6d28d9);}
.bcard.bc-emerald::before{background:linear-gradient(90deg,#047857,#0d9488);}
.bcard.bc-rose::before{background:linear-gradient(90deg,#be123c,#9d174d);}
.bcard.bc-amber::before{background:linear-gradient(90deg,#b45309,#c2410c);}
.bc-head{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;}
.bc-icon{width:52px;height:52px;border-radius:var(--r-md);display:flex;align-items:center;justify-content:center;font-size:21px;}
.bc-indigo .bc-icon{background:var(--indigo-l);color:var(--indigo);}
.bc-emerald .bc-icon{background:var(--emerald-l);color:var(--emerald);}
.bc-rose .bc-icon{background:var(--rose-l);color:var(--rose);}
.bc-amber .bc-icon{background:var(--amber-l);color:var(--amber);}
.bc-badge{font-size:11px;font-weight:700;padding:4px 10px;border-radius:999px;}
.badge-up{background:var(--emerald-s);color:var(--emerald);}
.badge-flat{background:var(--border2);color:var(--text3);}
.badge-down{background:var(--rose-s);color:var(--rose);}
.bc-num{font-size:40px;font-weight:900;line-height:1;letter-spacing:-2px;font-family:var(--mono);margin-bottom:5px;animation:countUp .5s var(--spring) both;}
.bc-lbl{font-size:14px;font-weight:700;color:var(--text2);}
.bc-sub{font-size:11.5px;color:var(--text3);margin-top:3px;}
.bc-prog{margin-top:16px;height:5px;background:var(--border2);border-radius:999px;overflow:hidden;}
.bc-prog-fill{height:100%;border-radius:999px;animation:barGrow .9s var(--ease) .3s both;}
.bc-indigo .bc-prog-fill{background:linear-gradient(90deg,#4338ca,#6d28d9);}
.bc-emerald .bc-prog-fill{background:linear-gradient(90deg,#047857,#0d9488);}
.bc-rose .bc-prog-fill{background:linear-gradient(90deg,#be123c,#9d174d);}
.bc-amber .bc-prog-fill{background:linear-gradient(90deg,#b45309,#c2410c);}

.mcard{background:#f0efff;border:1px solid var(--border);border-radius:var(--r-lg);padding:16px;text-align:center;text-decoration:none;color:inherit;box-shadow:var(--sh-xs);transition:all .2s var(--spring);animation:popIn .4s var(--ease) both;}
.mcard:hover{transform:translateY(-4px);box-shadow:var(--sh-md);color:inherit;text-decoration:none;}
.mc-ico{width:40px;height:40px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:16px;margin:0 auto 10px;}
.mc-num{font-size:22px;font-weight:900;line-height:1;font-family:var(--mono);}
.mc-lbl{font-size:10px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.5px;margin-top:5px;line-height:1.3;}

/* ═══════════════════════ QUICK ACTIONS ═══════════════════════ */
.qa-wrap{background:#f0efff;border:1px solid var(--border);border-radius:var(--r-xl);padding:22px;box-shadow:var(--sh-xs);margin-bottom:22px;}
.panel-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;}
.panel-hdr h3{font-size:15px;font-weight:800;color:var(--text1);display:flex;align-items:center;gap:8px;}
.panel-hdr h3 .dot{width:8px;height:8px;border-radius:50%;display:inline-block;}
.panel-hdr a{font-size:12px;font-weight:700;color:var(--indigo);text-decoration:none;}
.panel-hdr a:hover{text-decoration:underline;}
.qa-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;}
.qa-btn{display:flex;flex-direction:column;align-items:center;gap:10px;padding:18px 10px;background:var(--surface2);border:1.5px solid var(--border);border-radius:var(--r-lg);text-decoration:none;color:var(--text2);font-size:11.5px;font-weight:700;text-align:center;line-height:1.3;transition:all .25s var(--spring);cursor:pointer;position:relative;overflow:hidden;}
.qa-btn:hover{border-color:var(--indigo-s);color:var(--indigo);transform:translateY(-4px) scale(1.02);box-shadow:var(--sh-md);text-decoration:none;}
.qa-ico{width:44px;height:44px;border-radius:var(--r-sm);background:#f0efff;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--indigo);transition:all .2s;}
.qa-btn:hover .qa-ico{background:var(--indigo);color:#fff;border-color:var(--indigo);}

/* ═══════════════════════ CHART PANELS ═══════════════════════ */
.chart-row{display:grid;gap:20px;margin-bottom:22px;}
.cr-6040{grid-template-columns:1.4fr 1fr;}
.cr-5050{grid-template-columns:1fr 1fr;}
.cr-3col{grid-template-columns:repeat(3,1fr);}
.cpanel{background:#f0efff;border:1px solid var(--border);border-radius:var(--r-xl);padding:22px;box-shadow:var(--sh-xs);animation:fadeUp .4s var(--ease) both;}

/* ═══════════════════════ SANDWICH BARS ═══════════════════════ */
.sw-list{display:flex;flex-direction:column;gap:10px;margin-top:4px;}
.sw-row{display:flex;align-items:center;gap:10px;}
.sw-lbl{font-size:11.5px;font-weight:700;color:var(--text2);width:160px;flex-shrink:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.sw-track{flex:1;height:24px;background:var(--border2);border-radius:999px;overflow:hidden;}
.sw-fill{height:100%;border-radius:999px;display:flex;align-items:center;justify-content:flex-end;padding-right:10px;animation:barGrow .8s var(--ease) .15s both;}
.sw-fill span{font-size:10px;font-weight:800;color:#fff;white-space:nowrap;}
.sw-cnt{font-size:12.5px;font-weight:800;color:var(--text1);width:38px;text-align:right;font-family:var(--mono);flex-shrink:0;}

/* ═══════════════════════ SECTION-WISE SCROLLABLE ═══════════════════════ */
/* FIX: Section-wise now shows ALL grade-section combos in a scrollable container */
.sw-scroll-wrap{
  max-height:400px;
  overflow-y:auto;
  padding-right:4px;
  scrollbar-width:thin;
  scrollbar-color:var(--indigo-s) var(--border2);
}
.sw-scroll-wrap::-webkit-scrollbar{width:5px;}
.sw-scroll-wrap::-webkit-scrollbar-track{background:var(--border2);border-radius:999px;}
.sw-scroll-wrap::-webkit-scrollbar-thumb{background:var(--indigo-s);border-radius:999px;}
/* Grade group header */
.sw-grade-header{
  font-size:11px;font-weight:900;color:var(--indigo);
  text-transform:uppercase;letter-spacing:.8px;
  padding:8px 0 4px;border-bottom:1px solid var(--indigo-s);
  margin-bottom:6px;margin-top:10px;
}
.sw-grade-header:first-child{margin-top:0;}

/* ═══════════════════════ RING CHART ═══════════════════════ */
.ring-wrapper{display:flex;flex-direction:column;align-items:center;padding:8px 0;}
.ring-container{position:relative;width:150px;height:150px;margin-bottom:18px;}
.ring-container svg{transform:rotate(-90deg);}
.ring-inner{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;}
.ring-pct{font-size:30px;font-weight:900;font-family:var(--mono);line-height:1;}
.ring-subtext{font-size:10px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.6px;margin-top:2px;}
.ring-stats{display:flex;gap:24px;}
.rs .rv{font-size:24px;font-weight:900;font-family:var(--mono);line-height:1;}
.rs .rl{font-size:11px;font-weight:700;color:var(--text3);margin-top:3px;text-align:center;}

/* ═══════════════════════ GENDER BLOCKS ═══════════════════════ */
.gender-split{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:12px;}
.gblock{border-radius:var(--r-lg);padding:18px;text-align:center;}
.gblock.male{background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #bfdbfe;}
.gblock.female{background:linear-gradient(135deg,#fff1f2,#ffe4e6);border:1px solid #fecdd3;}
.gblock.unknown{background:linear-gradient(135deg,#f8fafc,#f1f5f9);border:1px solid #e2e8f0;}
.gb-icon{font-size:28px;margin-bottom:10px;}
.gblock.male .gb-icon{color:var(--blue);}
.gblock.female .gb-icon{color:var(--rose);}
.gblock.unknown .gb-icon{color:var(--text3);}
.gb-val{font-size:32px;font-weight:900;font-family:var(--mono);line-height:1;}
.gblock.male .gb-val{color:#1d4ed8;}
.gblock.female .gb-val{color:#be123c;}
.gblock.unknown .gb-val{color:var(--text3);}
.gb-lbl{font-size:11px;font-weight:700;margin-top:5px;}
.gblock.male .gb-lbl{color:var(--blue);}
.gblock.female .gb-lbl{color:var(--rose);}
.gblock.unknown .gb-lbl{color:var(--text3);}
.gb-pct{font-size:10px;font-weight:600;margin-top:3px;}
.gblock.male .gb-pct{color:#3b82f6;}
.gblock.female .gb-pct{color:#f43f5e;}
.gblock.unknown .gb-pct{color:var(--text3);}
/* note about unfilled gender */
.gender-note{font-size:11px;color:var(--amber);background:var(--amber-l);border:1px solid var(--amber-s);border-radius:var(--r-sm);padding:6px 10px;margin-top:10px;display:flex;align-items:center;gap:6px;}

/* ═══════════════════════ DATA TABLE PANELS ═══════════════════════ */
.tpanel{background:#f0efff;border:1px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.tpanel-hdr{padding:16px 20px;border-bottom:1px solid var(--border2);display:flex;align-items:center;justify-content:space-between;background:var(--surface2);}
.tpanel-hdr h3{font-size:14px;font-weight:800;color:var(--text1);display:flex;align-items:center;gap:8px;}
.tpanel-hdr a{font-size:12px;font-weight:700;color:var(--indigo);text-decoration:none;}
.tpanel-hdr a:hover{text-decoration:underline;}
.etbl{width:100%;border-collapse:collapse;}
.etbl th{font-size:10.5px;font-weight:800;color:var(--text3);text-transform:uppercase;letter-spacing:.6px;padding:11px 16px;background:#fafbfd;border-bottom:1px solid var(--border2);text-align:left;}
.etbl td{font-size:13px;font-weight:500;color:var(--text1);padding:12px 16px;border-bottom:1px solid var(--border2);vertical-align:middle;}
.etbl tr:last-child td{border-bottom:0;}
.etbl tr:hover td{background:#f8faff;}
.etbl a{color:var(--indigo);text-decoration:none;font-weight:700;}
.etbl a:hover{text-decoration:underline;}
.ava{width:34px;height:34px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:#fff;flex-shrink:0;margin-right:10px;}
.status-pill{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:800;padding:3px 10px;border-radius:999px;}
.status-pill::before{content:'';width:5px;height:5px;border-radius:50%;flex-shrink:0;}
.sp-active{background:var(--emerald-s);color:var(--emerald);}
.sp-active::before{background:var(--emerald);}
.sp-inactive{background:var(--rose-s);color:var(--rose);}
.sp-inactive::before{background:var(--rose);}
.sp-neutral{background:var(--border2);color:var(--text3);}
.sp-neutral::before{background:var(--text3);}
.pct-tag{font-size:11px;font-weight:800;padding:3px 9px;border-radius:999px;font-family:var(--mono);}
.pct-hi{background:var(--emerald-s);color:var(--emerald);}
.pct-mid{background:var(--amber-s);color:var(--amber);}
.pct-lo{background:var(--rose-s);color:var(--rose);}
.etbl-empty td{text-align:center;color:var(--text3);font-size:13px;padding:30px;font-style:italic;}
.t2col{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:22px;}
.t3col{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:22px;}

/* ═══════════════════════ ACADEMIC METRICS GRID ═══════════════════════ */
.acad4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:22px;}
.acard{background:#f0efff;border:1px solid var(--border);border-radius:var(--r-lg);padding:20px;display:flex;flex-direction:column;gap:12px;box-shadow:var(--sh-xs);transition:all .2s var(--spring);animation:popIn .4s var(--ease) both;}
.acard:hover{transform:translateY(-3px);box-shadow:var(--sh-md);}
.ac-hd{display:flex;align-items:center;justify-content:space-between;}
.ac-ico{width:46px;height:46px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:19px;}
.ac-pct-badge{font-size:11px;font-weight:800;padding:3px 10px;border-radius:999px;}
.ac-val{font-size:32px;font-weight:900;line-height:1;font-family:var(--mono);}
.ac-lbl{font-size:12px;font-weight:700;color:var(--text2);}
.ac-track{height:5px;background:var(--border2);border-radius:999px;overflow:hidden;}
.ac-fill{height:100%;border-radius:999px;animation:barGrow .8s var(--ease) .3s both;}

/* ═══════════════════════ TEACHER HERO ═══════════════════════ */
.teacher-hero{background:linear-gradient(130deg,#050e24,#1a3a8a,#4338ca,#6d28d9);border-radius:var(--r-xl);padding:28px;margin-bottom:22px;display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;position:relative;overflow:hidden;box-shadow:0 12px 40px rgba(67,56,202,.35);}
.teacher-hero::before{content:'';position:absolute;top:-60px;right:-60px;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,.06);}
.th-name{font-size:26px;font-weight:900;color:#fff;margin-bottom:6px;}
.th-sub{font-size:13px;color:rgba(255,255,255,.6);}
.th-sess-badge{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);border-radius:var(--r-md);padding:12px 18px;color:#fff;font-weight:700;font-size:13px;display:flex;align-items:center;gap:8px;z-index:2;position:relative;}

/* ═══════════════════════ COVERAGE CARDS ═══════════════════════ */
.coverage-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;margin-top:12px;}
.coverage-card{background:var(--surface2);border:1px solid var(--border);border-radius:var(--r-lg);padding:16px;transition:all .2s var(--spring);position:relative;overflow:hidden;}
.coverage-card:hover{transform:translateY(-3px);box-shadow:var(--sh-md);border-color:var(--indigo-s);}
.coverage-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
.coverage-title{font-weight:800;font-size:14px;color:var(--text1);}
.coverage-badge{font-size:11px;font-weight:800;padding:4px 10px;border-radius:999px;}
.coverage-details{display:flex;gap:12px;margin-bottom:12px;font-size:12px;color:var(--text2);flex-wrap:wrap;}
.coverage-details i{width:16px;color:var(--indigo);}
.coverage-chapters{background:var(--indigo-l);border-radius:var(--r-sm);padding:8px 12px;margin:12px 0;font-size:11px;color:var(--indigo);font-weight:600;}
.coverage-progress-bar{height:6px;background:var(--border2);border-radius:999px;overflow:hidden;margin-bottom:6px;}
.coverage-progress-fill{height:100%;border-radius:999px;}
.coverage-percent{font-size:12px;font-weight:800;text-align:right;}

/* ═══════════════════════ HEATMAP (FIXED) ═══════════════════════ */
/* FIX: Added proper CSS for heatmap grid that was missing */
.heatmap-g{
  display:grid;
  grid-template-columns:repeat(12,1fr);
  gap:6px;
}
.hm-cell{
  height:40px;
  border-radius:var(--r-sm);
  cursor:pointer;
  position:relative;
  transition:transform .15s, opacity .15s;
}
.hm-cell:hover{transform:scale(1.15);opacity:.9;z-index:2;}
.hm-tooltip{
  display:none;
  position:absolute;
  bottom:calc(100%+6px);
  left:50%;transform:translateX(-50%);
  background:#0a1628;color:#fff;
  font-size:11px;font-weight:600;
  padding:5px 10px;border-radius:var(--r-sm);
  white-space:nowrap;z-index:10;
  pointer-events:none;
}
.hm-cell:hover .hm-tooltip{display:block;}

/* ═══════════════════════ RESPONSIVE ═══════════════════════ */
@media(max-width:1400px){.mc8{grid-template-columns:repeat(4,1fr);}}
@media(max-width:1200px){.mc4{grid-template-columns:repeat(2,1fr);}.cr-6040,.cr-5050,.cr-3col{grid-template-columns:1fr;}.qa-grid{grid-template-columns:repeat(3,1fr);}.t2col,.t3col{grid-template-columns:1fr;}.acad4{grid-template-columns:repeat(2,1fr);}}
@media(max-width:900px){.mc4,.mc8{grid-template-columns:repeat(2,1fr);}.hdr-top{flex-direction:column;align-items:flex-start;}.hdr-search{min-width:100%;}.clock-box{width:100%;}}
@media(max-width:600px){.erp-body{padding:14px 14px 30px;}.qa-grid{grid-template-columns:repeat(2,1fr);}.coverage-grid{grid-template-columns:1fr;}.heatmap-g{grid-template-columns:repeat(6,1fr);}}


.brand-text111 {
color:white;    
}
</style>

<div class="erpd">
<div class="content-wrapper">

{{-- ══════════════════ HEADER ══════════════════ --}}
<div class="erp-header">
  <div class="hdr-geo">
    <div class="circle c1"></div>
    <div class="circle c2"></div>
    <div class="circle c3"></div>
  </div>

  <div class="hdr-top">
    <div class="hdr-brand">
      <div class="brand-avatar"><i class="fas fa-graduation-cap"></i></div>
      <div class="brand-text111">
        <h1 style="color:white">{{ config('app.name', 'Hisab Mittra CRM') }}</h1>
        <div class="sub" id="hdrGreet">Loading...</div>
      </div>
    </div>

    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
      <div class="clock-box">
        <div class="clock-digits" id="clockTime">00<span class="sep">:</span>00<span class="sep">:</span>00</div>
        <div class="clock-meta">
          <div class="clock-day" id="clockDay">---</div>
          <div class="clock-date" id="clockDate">---</div>
        </div>
      </div>

      @if(!$isTeacher)
      <div class="hdr-search">
        <i class="fas fa-search si"></i>
        <input type="text" id="srchInput" placeholder="Search student / teacher…" autocomplete="off">
        <button class="mic" id="micBtn" title="Voice Search"><i class="fas fa-microphone"></i></button>
        <div class="srch-drop" id="srchDrop"></div>
      </div>
      @endif

      @if(isset($activeSession))
      <div class="sess-pill">
        <i class="fas fa-calendar-check"></i>
        <span>{{ $activeSession->name ?? 'No Session' }}</span>
      </div>
      @endif
    </div>
  </div>

  @if(!$isTeacher)
  <div class="hdr-nav">
    <div class="hnav-tab active" data-tab="overview"><i class="fas fa-th-large"></i> Overview</div>
    <div class="hnav-tab" data-tab="academic"><i class="fas fa-graduation-cap"></i> Academics</div>
    <div class="hnav-tab" data-tab="people"><i class="fas fa-users"></i> People</div>
  </div>
  @endif
</div>

{{-- ══════════════════ BODY ══════════════════ --}}
<div class="erp-body">

@if($isTeacher)
{{-- ════════════ TEACHER DASHBOARD ════════════ --}}
  <div class="teacher-hero">
    <div style="position:relative;z-index:2;">
      <div class="th-name">Welcome, {{ $teacher->name ?? $user->name }} 👋</div>
      <div class="th-sub">Your classes, syllabus progress and marks activity — all in one view.</div>
    </div>
    <div class="th-sess-badge"><i class="fas fa-calendar-check"></i> {{ $activeSession->name ?? 'No active session' }}</div>
  </div>

  <div class="mc4">
    @php $tcards=[
      ['l'=>'My Classes',        'v'=>$teacherStats['classes']  ?? 0,'ico'=>'fa-layer-group',   'c'=>'bc-indigo'],
      ['l'=>'My Sections',       'v'=>$teacherStats['sections'] ?? 0,'ico'=>'fa-th',            'c'=>'bc-emerald'],
      ['l'=>'My Subjects',       'v'=>$teacherStats['subjects'] ?? 0,'ico'=>'fa-book-open',     'c'=>'bc-rose'],
      ['l'=>'Assigned Students', 'v'=>$teacherStats['students'] ?? 0,'ico'=>'fa-user-graduate', 'c'=>'bc-amber'],
    ]; @endphp
    @foreach($tcards as $tc)
    <div class="bcard {{ $tc['c'] }}">
      <div class="bc-head"><div class="bc-icon"><i class="fas {{ $tc['ico'] }}"></i></div></div>
      <div class="bc-num">{{ number_format($tc['v']) }}</div>
      <div class="bc-lbl">{{ $tc['l'] }}</div>
    </div>
    @endforeach
  </div>

  <div class="qa-wrap">
    <div class="panel-hdr"><h3><span class="dot" style="background:var(--indigo);"></span>Quick Actions</h3></div>
    <div class="qa-grid">
      @php $tqa=[
        ['label'=>'Mark Evaluation',     'icon'=>'fa-pen-alt',            'url'=>url('admin/mark-evaluation')],
        ['label'=>'View Marks',          'icon'=>'fa-list-ul',            'url'=>url('admin/student-marks-list')],
        ['label'=>'Syllabus Tracker',    'icon'=>'fa-chalkboard-teacher', 'url'=>url('admin/teacher-chapter-progress')],
        ['label'=>'Grade-wise Syllabus', 'icon'=>'fa-chart-pie',          'url'=>url('teacher/chapter-status-report')],
        ['label'=>'Exam Coverage',       'icon'=>'fa-book-reader',        'url'=>url('admin/syllabus-coverage')],
      ]; @endphp
      @foreach($tqa as $qa)
      <a href="{{ $qa['url'] }}" class="qa-btn">
        <div class="qa-ico"><i class="fas {{ $qa['icon'] }}"></i></div>
        <span>{{ $qa['label'] }}</span>
      </a>
      @endforeach
    </div>
  </div>

  <div class="t2col">
    <div class="tpanel">
      <div class="tpanel-hdr"><h3><i class="fas fa-chalkboard"></i> Assigned Classes</h3></div>
      <table class="etbl">
        <thead><tr><th>Class</th><th>Section</th><th>Subject</th></tr></thead>
        <tbody>
          @forelse($assignments ?? [] as $a)
          <tr>
            <td>{{ $a->grade_name ?? '-' }}</td>
            <td>{{ $a->section_name ?? '-' }}</td>
            <td>{{ $a->subject_name ?? '-' }}</td>
          </tr>
          @empty<tr class="etbl-empty"><td colspan="3">No assignment found.</td></tr>@endforelse
        </tbody>
      </table>
    </div>
    <div class="tpanel">
      <div class="tpanel-hdr">
        <h3><i class="fas fa-edit"></i> Recent Marks</h3>
        <a href="{{ url('admin/student-marks-list') }}">View all</a>
      </div>
      <table class="etbl">
        <thead><tr><th>Student</th><th>Exam</th><th>Subject</th><th>Score</th></tr></thead>
        <tbody>
          @forelse($teacherRecentMarks ?? [] as $m)
          <tr>
            <td>{{ $m->student_name ?: 'Student #'.$m->student_id }}</td>
            <td>{{ $m->exam_name ?? '-' }}</td>
            <td>{{ $m->subject_name ?? '-' }}</td>
            <td>
              @if(($m->max_mark ?? 0) > 0)
                @php $p = round(($m->obtained_mark / $m->max_mark) * 100); @endphp
                <span class="pct-tag {{ $p >= 75 ? 'pct-hi' : ($p >= 50 ? 'pct-mid' : 'pct-lo') }}">{{ $p }}%</span>
              @else -@endif
            </td>
          </tr>
          @empty<tr class="etbl-empty"><td colspan="4">No marks yet.</td></tr>@endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if(isset($teacherCoverages) && $teacherCoverages->count() > 0)
  <div class="qa-wrap" style="margin-top:20px;">
    <div class="panel-hdr">
      <h3><span class="dot" style="background:var(--indigo);"></span><i class="fas fa-book-open"></i> Recent Syllabus Coverages</h3>
      <a href="{{ url('admin/syllabus-coverage') }}">View all →</a>
    </div>
    <div class="coverage-grid">
      @foreach($teacherCoverages as $cov)
      <div class="coverage-card">
        <div class="coverage-header">
          <span class="coverage-title"><i class="fas fa-file-alt" style="margin-right:6px;color:var(--indigo);"></i>{{ $cov->exam_name ?? 'Exam' }}</span>
          <span class="coverage-badge {{ ($cov->coverage_percent ?? 0) >= 75 ? 'pct-hi' : (($cov->coverage_percent ?? 0) >= 50 ? 'pct-mid' : 'pct-lo') }}">{{ $cov->coverage_percent ?? 0 }}%</span>
        </div>
        <div class="coverage-details">
          <div><i class="fas fa-graduation-cap"></i> {{ $cov->grade_name ?? 'N/A' }}</div>
          <div><i class="fas fa-book"></i> {{ $cov->subject_name ?? 'N/A' }}</div>
          <div><i class="fas fa-calendar"></i> {{ isset($cov->created_at) ? \Carbon\Carbon::parse($cov->created_at)->format('d M Y') : 'N/A' }}</div>
        </div>
        <div class="coverage-chapters">
          <i class="fas fa-list"></i> <strong>Chapters:</strong>
          @if(($cov->chapter_count ?? 0) > 0)
            {{ $cov->chapter_range ?? 'N/A' }} <span style="font-size:10px;opacity:.7;">({{ $cov->chapter_count }} chapters)</span>
          @else
            No chapters selected
          @endif
        </div>
        @if(($cov->covered_pages ?? 0) > 0 && ($cov->total_pages ?? 0) > 0)
        <div style="font-size:12px;color:var(--text2);margin-bottom:8px;"><i class="fas fa-file"></i> Pages: {{ $cov->covered_pages }}/{{ $cov->total_pages }}</div>
        @endif
        <div class="coverage-progress-bar">
          <div class="coverage-progress-fill" style="width:{{ $cov->coverage_percent ?? 0 }}%;background:linear-gradient(90deg,var(--indigo),var(--violet));"></div>
        </div>
        <div class="coverage-percent">{{ $cov->coverage_percent ?? 0 }}% Complete</div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

@else
{{-- ════════════ ADMIN DASHBOARD ════════════ --}}

  {{-- ────── TAB: OVERVIEW ────── --}}
  <div class="tab-pane active" id="tab-overview">

    {{-- Today Pulse Banner --}}
    <div class="pulse-banner">
      <div class="pb-deco pb-deco-1"></div>
      <div class="pb-deco pb-deco-2"></div>
      <div class="pb-left">
        <h3><i class="fas fa-bolt" style="color:#fbbf24;"></i> Today's Pulse <span class="pb-live">Live</span></h3>
        <p id="todayStr">Loading...</p>
      </div>
      <div class="pb-pills">
        <div class="pb-pill"><div class="pv">{{ $dashboard['new_students_today'] ?? 0 }}</div><div class="pl">New Students</div></div>
        <div class="pb-pill"><div class="pv">{{ $dashboard['transfers_today'] ?? 0 }}</div><div class="pl">TC Issued</div></div>
        <div class="pb-pill"><div class="pv">{{ $dashboard['active_students'] ?? 0 }}</div><div class="pl">Total Active</div></div>
        <div class="pb-pill"><div class="pv">{{ $dashboard['new_students_month'] ?? 0 }}</div><div class="pl">This Month</div></div>
      </div>
    </div>

    {{-- Primary 4 KPI Cards --}}
    @php
      $totalEnrolled = ($dashboard['active_students'] ?? 0) + ($dashboard['inactive_students'] ?? 0);
      $pA = $totalEnrolled > 0 ? round((($dashboard['active_students'] ?? 0) / $totalEnrolled) * 100) : 0;
      $pT = ($dashboard['teachers'] ?? 0) > 0 ? round((($dashboard['teacher_assigned'] ?? 0) / ($dashboard['teachers'] ?? 1)) * 100) : 0;
      $pM = ($dashboard['active_students'] ?? 0) > 0
          ? min(100, round((($dashboard['marked_students'] ?? 0) / ($dashboard['active_students'] ?? 1)) * 100))
          : 0;
    @endphp
    <div class="mc4">
      <a href="{{ url('admin/student-list') }}" class="bcard bc-indigo" style="animation-delay:.05s;">
        <div class="bc-head">
          <div class="bc-icon"><i class="fas fa-user-graduate"></i></div>
          <span class="bc-badge badge-up"><i class="fas fa-arrow-up" style="font-size:9px;"></i> {{ $dashboard['new_students_month'] ?? 0 }} this month</span>
        </div>
        <div class="bc-num">{{ number_format($dashboard['active_students'] ?? 0) }}</div>
        <div class="bc-lbl">Active Students</div>
        <div class="bc-sub">{{ number_format($dashboard['inactive_students'] ?? 0) }} inactive / transferred</div>
        <div class="bc-prog"><div class="bc-prog-fill" style="width:{{ $pA }}%;"></div></div>
      </a>

      <a href="{{ url('admin/teacher') }}" class="bcard bc-emerald" style="animation-delay:.1s;">
        <div class="bc-head">
          <div class="bc-icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <span class="bc-badge badge-up">{{ $dashboard['teacher_assigned'] ?? 0 }} assigned</span>
        </div>
        <div class="bc-num">{{ number_format($dashboard['teachers'] ?? 0) }}</div>
        <div class="bc-lbl">Total Teachers</div>
        <div class="bc-sub">{{ $dashboard['teacher_unassigned'] ?? 0 }} not yet assigned</div>
        <div class="bc-prog"><div class="bc-prog-fill" style="width:{{ $pT }}%;"></div></div>
      </a>

      <a href="{{ url('admin/subject') }}" class="bcard bc-rose" style="animation-delay:.15s;">
        <div class="bc-head">
          <div class="bc-icon"><i class="fas fa-book-open"></i></div>
          <span class="bc-badge badge-flat">{{ $dashboard['chapters'] ?? 0 }} chapters</span>
        </div>
        <div class="bc-num">{{ number_format($dashboard['subjects'] ?? 0) }}</div>
        <div class="bc-lbl">Subjects</div>
        <div class="bc-sub">Across {{ $dashboard['grades'] ?? 0 }} grades · {{ $dashboard['sections'] ?? 0 }} sections</div>
        <div class="bc-prog"><div class="bc-prog-fill" style="width:{{ $dashboard['syllabus_progress'] ?? 0 }}%;"></div></div>
      </a>

      <a href="{{ url('admin/exam') }}" class="bcard bc-amber" style="animation-delay:.2s;">
        <div class="bc-head">
          <div class="bc-icon"><i class="fas fa-file-alt"></i></div>
          <span class="bc-badge {{ ($dashboard['marked_students'] ?? 0) > 0 ? 'badge-up' : 'badge-flat' }}">{{ $dashboard['marked_students'] ?? 0 }} marked</span>
        </div>
        <div class="bc-num">{{ number_format($dashboard['exams'] ?? 0) }}</div>
        <div class="bc-lbl">Exams Configured</div>
        <div class="bc-sub">{{ number_format($dashboard['marks_entries'] ?? 0) }} total mark entries</div>
        <div class="bc-prog"><div class="bc-prog-fill" style="width:{{ $pM }}%;"></div></div>
      </a>
    </div>

    {{-- Mini 8-grid --}}
    <div class="mc8">
      @php $mis=[
        ['l'=>'Grades',     'v'=>$dashboard['grades'] ?? 0,                  'ico'=>'fa-layer-group',    'url'=>url('admin/grade'),                    'col'=>'#4338ca'],
        ['l'=>'Sections',   'v'=>$dashboard['sections'] ?? 0,                'ico'=>'fa-th',             'url'=>url('admin/section'),                  'col'=>'#047857'],
        ['l'=>'Sessions',   'v'=>$dashboard['sessions'] ?? 0,                'ico'=>'fa-calendar-alt',   'url'=>url('admin/session'),                  'col'=>'#0d9488'],
        ['l'=>'Chapters',   'v'=>$dashboard['chapters'] ?? 0,                'ico'=>'fa-tasks',          'url'=>url('admin/chapter'),                  'col'=>'#b45309'],
        ['l'=>'TC Issued',  'v'=>$dashboard['transfer_certificates'] ?? 0,   'ico'=>'fa-file-signature', 'url'=>url('admin/transfer-list'),            'col'=>'#be123c'],
        ['l'=>'Promotions', 'v'=>$dashboard['promotions'] ?? 0,              'ico'=>'fa-level-up-alt',   'url'=>url('admin/student-promote'),          'col'=>'#c2410c'],
        ['l'=>'Syllabus %', 'v'=>($dashboard['syllabus_progress'] ?? 0).'%','ico'=>'fa-chart-pie',       'url'=>url('admin/teacher-chapter-progress'), 'col'=>'#6d28d9'],
        ['l'=>'Inactive',   'v'=>$dashboard['inactive_students'] ?? 0,       'ico'=>'fa-user-slash',     'url'=>url('admin/student-list'),             'col'=>'#9d174d'],
      ]; @endphp
      @foreach($mis as $i => $mi)
      <a href="{{ $mi['url'] }}" class="mcard" style="animation-delay:{{ 0.05 + $i * .04 }}s;">
        <div class="mc-ico" style="background:{{ $mi['col'] }}18;color:{{ $mi['col'] }};"><i class="fas {{ $mi['ico'] }}"></i></div>
        <div class="mc-num" style="color:{{ $mi['col'] }};">{{ is_numeric($mi['v']) ? number_format($mi['v']) : $mi['v'] }}</div>
        <div class="mc-lbl">{{ $mi['l'] }}</div>
      </a>
      @endforeach
    </div>

    {{-- Quick Actions --}}
    <div class="qa-wrap">
      <div class="panel-hdr"><h3><span class="dot" style="background:var(--indigo);"></span>Quick Actions</h3></div>
      <div class="qa-grid">
        @php $qas=[
          ['label'=>'Add Student',      'icon'=>'fa-user-plus',    'url'=>url('admin/student-add')],
          ['label'=>'Bulk Upload',      'icon'=>'fa-file-import',  'url'=>url('admin/student-bulk-upload')],
          ['label'=>'Mark Evaluation',  'icon'=>'fa-pen-alt',      'url'=>url('admin/mark-evaluation')],
          ['label'=>'Admit Card',       'icon'=>'fa-id-card',      'url'=>url('admin/generate-admitcard')],
          ['label'=>'Generate Result',  'icon'=>'fa-award',        'url'=>url('admin/generate-result')],
          ['label'=>'Promote Students', 'icon'=>'fa-level-up-alt', 'url'=>url('admin/student-promote')],
        ]; @endphp
        @foreach($qas as $qa)
        <a href="{{ $qa['url'] }}" class="qa-btn">
          <div class="qa-ico"><i class="fas {{ $qa['icon'] }}"></i></div>
          <span>{{ $qa['label'] }}</span>
        </a>
        @endforeach
      </div>
    </div>

    {{-- Chart Row 1: Monthly Line + Gender --}}
    <div class="chart-row cr-6040">
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;">
          <h3><span class="dot" style="background:var(--indigo);"></span>Monthly Academic Activity — {{ date('Y') }}</h3>
          <span class="pb-live">Live</span>
        </div>
        <div style="height:240px;position:relative;">
          <canvas id="monthlyChart"></canvas>
        </div>
      </div>
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:12px;">
          <h3><span class="dot" style="background:var(--violet);"></span>Gender Breakdown</h3>
        </div>
        @php
          $totalGenderFilled = ($dashboard['male_students'] ?? 0) + ($dashboard['female_students'] ?? 0);
          $mPct = $totalGenderFilled > 0 ? round((($dashboard['male_students'] ?? 0) / $totalGenderFilled) * 100) : 0;
          $fPct = $totalGenderFilled > 0 ? round((($dashboard['female_students'] ?? 0) / $totalGenderFilled) * 100) : 0;
          $gUnknown = $dashboard['gender_unknown_students'] ?? 0;
        @endphp
        <div class="gender-split">
          <div class="gblock male">
            <div class="gb-icon"><i class="fas fa-mars"></i></div>
            <div class="gb-val">{{ number_format($dashboard['male_students'] ?? 0) }}</div>
            <div class="gb-lbl">Male Students</div>
            {{-- FIX: show % of filled-gender students only, not total --}}
            <div class="gb-pct">{{ $mPct }}% of gendered</div>
          </div>
          <div class="gblock female">
            <div class="gb-icon"><i class="fas fa-venus"></i></div>
            <div class="gb-val">{{ number_format($dashboard['female_students'] ?? 0) }}</div>
            <div class="gb-lbl">Female Students</div>
            <div class="gb-pct">{{ $fPct }}% of gendered</div>
          </div>
        </div>
        {{-- FIX: Show gender-unfilled count as a notice so admin is aware --}}
        @if($gUnknown > 0)
        <div class="gender-note">
          <i class="fas fa-exclamation-triangle"></i>
          {{ number_format($gUnknown) }} students have gender not filled in records.
        </div>
        @endif
        <div style="height:100px;position:relative;margin-top:10px;">
          <canvas id="genderDonut"></canvas>
        </div>
      </div>
    </div>

    {{-- Chart Row 2: Grade bar + Section sandwich + Syllabus ring --}}
    <div class="chart-row cr-3col">
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;">
          <h3><span class="dot" style="background:var(--emerald);"></span>Students by Grade</h3>
        </div>
        <div style="height:230px;position:relative;">
          <canvas id="gradeChart"></canvas>
        </div>
      </div>

      {{-- FIX: Section-wise now shows ALL sections (no limit), grouped by grade, scrollable --}}
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;">
          <h3><span class="dot" style="background:var(--amber);"></span>Section-wise Students</h3>
          <span style="font-size:11px;color:var(--text3);">{{ ($sectionWise ?? collect())->count() }} groups</span>
        </div>
        @php
          $swCols=['#4338ca','#047857','#6d28d9','#b45309','#be123c','#0d9488','#c2410c','#0284c7','#9d174d','#0e7490'];
          $swMax = ($sectionWise ?? collect())->max('total') ?: 1;
          // Group sections by grade for better readability
          $swGrouped = ($sectionWise ?? collect())->groupBy('grade_name');
        @endphp
        <div class="sw-scroll-wrap">
          @php $swColorIdx = 0; @endphp
          @foreach($swGrouped as $gradeName => $sections)
          <div class="sw-grade-header">{{ $gradeName }}</div>
          @foreach($sections as $sw)
          @php $barCol = $swCols[$swColorIdx % count($swCols)]; $swColorIdx++; @endphp
          <div class="sw-row">
            <div class="sw-lbl" title="{{ $sw->section_name ?? '' }}">{{ $sw->section_name ?? '' }}</div>
            <div class="sw-track">
              <div class="sw-fill" style="width:{{ round(($sw->total / $swMax) * 100) }}%;background:{{ $barCol }};">
                @if(($sw->total ?? 0) > 3)<span>{{ $sw->total }}</span>@endif
              </div>
            </div>
            <div class="sw-cnt">{{ $sw->total ?? 0 }}</div>
          </div>
          @endforeach
          @endforeach
          @if(($sectionWise ?? collect())->isEmpty())
          <div style="text-align:center;color:var(--text3);padding:28px;font-size:13px;">No data available.</div>
          @endif
        </div>
      </div>

      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;">
          <h3><span class="dot" style="background:var(--violet);"></span>Syllabus Progress</h3>
        </div>
        @php
          $sp  = $dashboard['syllabus_progress'] ?? 0;
          $R   = 58; $C = round(2 * pi() * $R, 1);
          $OFF = round($C * (1 - $sp / 100), 1);
        @endphp
        <div class="ring-wrapper">
          <div class="ring-container">
            <svg viewBox="0 0 140 140" width="140" height="140">
              <defs><linearGradient id="rg1" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#4338ca"/><stop offset="100%" stop-color="#0284c7"/></linearGradient></defs>
              <circle cx="70" cy="70" r="{{ $R }}" fill="none" stroke="#e2e8f4" stroke-width="12"/>
              <circle cx="70" cy="70" r="{{ $R }}" fill="none" stroke="url(#rg1)" stroke-width="12" stroke-linecap="round" stroke-dasharray="{{ $C }}" stroke-dashoffset="{{ $OFF }}" style="transition:stroke-dashoffset .9s ease;"/>
            </svg>
            <div class="ring-inner">
              <div class="ring-pct" style="color:var(--indigo);">{{ $sp }}%</div>
              <div class="ring-subtext">Syllabus</div>
            </div>
          </div>
          <div class="ring-stats">
            <div class="rs"><div class="rv" style="color:var(--emerald);">{{ number_format($dashboard['completed_chapters'] ?? 0) }}</div><div class="rl">Done</div></div>
            <div class="rs"><div class="rv" style="color:var(--rose);">{{ number_format(($dashboard['chapters'] ?? 0) - ($dashboard['completed_chapters'] ?? 0)) }}</div><div class="rl">Left</div></div>
            <div class="rs"><div class="rv">{{ number_format($dashboard['chapters'] ?? 0) }}</div><div class="rl">Total</div></div>
          </div>
        </div>
      </div>
    </div>

    {{-- Chart Row 3: Exam + Subject --}}
    <div class="chart-row cr-5050">
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;">
          <h3><span class="dot" style="background:var(--rose);"></span>Exam Performance (Avg %)</h3>
        </div>
        <div style="height:230px;position:relative;">
          <canvas id="examChart"></canvas>
        </div>
      </div>
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;">
          <h3><span class="dot" style="background:var(--cyan);"></span>Subject-wise Marks Entries</h3>
        </div>
        @php
          $sCols=['#4338ca','#b45309','#047857','#be123c','#0284c7','#c2410c','#6d28d9','#0d9488','#9d174d','#0e7490'];
          $sjMax = ($subjectMarks ?? collect())->max('total_entries') ?: 1;
        @endphp
        <div class="sw-list">
          @foreach($subjectMarks ?? [] as $si => $sm)
          <div class="sw-row">
            <div class="sw-lbl" title="{{ $sm->subject_name ?? '' }}">{{ $sm->subject_name ?? '' }}</div>
            <div class="sw-track">
              <div class="sw-fill" style="width:{{ round((($sm->total_entries ?? 0) / $sjMax) * 100) }}%;background:{{ $sCols[$si % count($sCols)] }};">
                <span>{{ $sm->total_entries ?? 0 }}</span>
              </div>
            </div>
            <div class="sw-cnt">{{ $sm->total_entries ?? 0 }}</div>
          </div>
          @endforeach
          @if(($subjectMarks ?? collect())->isEmpty())
          <div style="text-align:center;color:var(--text3);padding:28px;font-size:13px;">No marks data yet.</div>
          @endif
        </div>
      </div>
    </div>

    {{-- Recent Tables --}}
    <div class="t2col">
      <div class="tpanel">
        <div class="tpanel-hdr">
          <h3><i class="fas fa-user-graduate"></i> Recent Students</h3>
          <a href="{{ url('admin/student-list') }}">View all →</a>
        </div>
        <table class="etbl">
          <thead><tr><th>Student</th><th>No.</th><th>Class</th><th>Status</th></tr></thead>
          <tbody>
            @php $aBgs=['#4338ca','#047857','#6d28d9','#b45309','#be123c','#0d9488','#c2410c']; @endphp
            @forelse($recentStudents ?? [] as $s)
            @php
              $n = trim(($s->first_name ?? '').' '.($s->middle_name ?? '').' '.($s->last_name ?? '')) ?: 'Student';
              $ini = strtoupper(substr($s->first_name ?? '', 0, 1) . substr($s->last_name ?? '', 0, 1));
              $bg = $aBgs[crc32($s->id ?? '') % count($aBgs)];
            @endphp
            <tr>
              <td><div style="display:flex;align-items:center;">
                <span class="ava" style="background:{{ $bg }}">{{ $ini }}</span>
                <a href="{{ url('admin/student-edit/'.($s->id ?? '')) }}">{{ $n }}</a>
              </div></td>
              <td style="font-family:var(--mono);font-size:12px;">{{ $s->admission_no ?? '-' }}</td>
              <td>{{ $s->grade_name ?? '-' }}{{ isset($s->section_name) ? ' ('.$s->section_name.')' : '' }}</td>
              <td><span class="status-pill {{ ($s->status ?? '') === 'Active' ? 'sp-active' : 'sp-inactive' }}">{{ $s->status ?? '-' }}</span></td>
            </tr>
            @empty<tr class="etbl-empty"><td colspan="4">No students found.</td></tr>@endforelse
          </tbody>
        </table>
      </div>
      <div class="tpanel">
        <div class="tpanel-hdr">
          <h3><i class="fas fa-edit"></i> Recent Mark Entries</h3>
          <a href="{{ url('admin/student-marks-list') }}">View all →</a>
        </div>
        <table class="etbl">
          <thead><tr><th>Student</th><th>Exam</th><th>Subj.</th><th>Avg %</th></tr></thead>
          <tbody>
            @forelse($recentMarks ?? [] as $m)
            <tr>
              <td>{{ $m->student_name ?? 'Student #'.$m->student_id }}</td>
              <td style="font-size:12px;">{{ $m->exam_name ?? '-' }}</td>
              <td style="font-family:var(--mono);">{{ $m->subjects ?? '-' }}</td>
              <td>
                @if(($m->avg_percent ?? null) !== null)
                  <span class="pct-tag {{ ($m->avg_percent >= 75) ? 'pct-hi' : (($m->avg_percent >= 50) ? 'pct-mid' : 'pct-lo') }}">{{ $m->avg_percent }}%</span>
                @else
                  <span class="pct-tag pct-mid">—</span>
                @endif
              </td>
            </tr>
            @empty<tr class="etbl-empty"><td colspan="4">No marks yet.</td></tr>@endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="tpanel" style="margin-bottom:22px;">
      <div class="tpanel-hdr">
        <h3><i class="fas fa-chalkboard-teacher"></i> Recent Teachers</h3>
        <a href="{{ url('admin/teacher') }}">View all →</a>
      </div>
      <table class="etbl">
        <thead><tr><th>Teacher</th><th>ID</th><th>Phone</th><th>Gender</th><th>Status</th></tr></thead>
        <tbody>
          @php $tBgs=['#047857','#4338ca','#6d28d9','#b45309']; @endphp
          @forelse($recentTeachers ?? [] as $t)
          @php $tIni = strtoupper(substr($t->name ?? '', 0, 2)); $tBg = $tBgs[crc32($t->id_hash ?? '') % count($tBgs)]; @endphp
          <tr>
            <td><div style="display:flex;align-items:center;">
              <span class="ava" style="background:{{ $tBg }}">{{ $tIni }}</span>
              <a href="{{ url('admin/edit-teacher/'.($t->id_hash ?? '')) }}">{{ $t->name ?? '-' }}</a>
            </div></td>
            <td style="font-family:var(--mono);font-size:12px;">{{ $t->teacher_id ?? '-' }}</td>
            <td>{{ $t->phone ?? '-' }}</td>
            <td>{{ $t->gender ?? '-' }}</td>
            <td><span class="status-pill {{ ($t->status ?? '') === 'Active' ? 'sp-active' : 'sp-neutral' }}">{{ $t->status ?? '-' }}</span></td>
          </tr>
          @empty<tr class="etbl-empty"><td colspan="5">No teachers found.</td></tr>@endforelse
        </tbody>
      </table>
    </div>

  </div>{{-- /tab-overview --}}

  {{-- ────── TAB: ACADEMIC ────── --}}
  <div class="tab-pane" id="tab-academic">
    <div class="acad4">
      @php
      $acadCards=[
        ['l'=>'Total Subjects',   'v'=>$dashboard['subjects'] ?? 0,           'ico'=>'fa-book-open',     'col'=>'#4338ca','bg'=>'#eef2ff','pct'=>80],
        ['l'=>'Total Exams',      'v'=>$dashboard['exams'] ?? 0,              'ico'=>'fa-file-alt',      'col'=>'#be123c','bg'=>'#fff1f2','pct'=>65],
        ['l'=>'Total Chapters',   'v'=>$dashboard['chapters'] ?? 0,           'ico'=>'fa-tasks',         'col'=>'#b45309','bg'=>'#fffbeb','pct'=>$dashboard['syllabus_progress'] ?? 0],
        ['l'=>'Chapters Done',    'v'=>$dashboard['completed_chapters'] ?? 0, 'ico'=>'fa-check-double',  'col'=>'#047857','bg'=>'#ecfdf5','pct'=>$dashboard['syllabus_progress'] ?? 0],
        ['l'=>'Mark Entries',     'v'=>$dashboard['marks_entries'] ?? 0,      'ico'=>'fa-pen-alt',       'col'=>'#0e7490','bg'=>'#ecfeff','pct'=>70],
        ['l'=>'Students Marked',  'v'=>$dashboard['marked_students'] ?? 0,    'ico'=>'fa-user-check',    'col'=>'#6d28d9','bg'=>'#ede9fe','pct'=>$pM ?? 0],
        ['l'=>'Transfer Certs.',  'v'=>$dashboard['transfer_certificates']??0,'ico'=>'fa-file-signature','col'=>'#c2410c','bg'=>'#fff7ed','pct'=>40],
        ['l'=>'Total Promotions', 'v'=>$dashboard['promotions'] ?? 0,         'ico'=>'fa-level-up-alt',  'col'=>'#9d174d','bg'=>'#fdf2f8','pct'=>55],
      ];
      @endphp
      @foreach($acadCards as $i => $ac)
      <div class="acard" style="animation-delay:{{ $i * .05 }}s;">
        <div class="ac-hd">
          <div class="ac-ico" style="background:{{ $ac['bg'] }};color:{{ $ac['col'] }};"><i class="fas {{ $ac['ico'] }}"></i></div>
          <span class="ac-pct-badge" style="background:{{ $ac['bg'] }};color:{{ $ac['col'] }};">{{ $ac['pct'] }}%</span>
        </div>
        <div class="ac-val" style="color:{{ $ac['col'] }};">{{ number_format($ac['v']) }}</div>
        <div class="ac-lbl">{{ $ac['l'] }}</div>
        <div class="ac-track"><div class="ac-fill" style="width:{{ $ac['pct'] }}%;background:{{ $ac['col'] }};"></div></div>
      </div>
      @endforeach
    </div>

    <div class="chart-row cr-5050">
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;"><h3><span class="dot" style="background:var(--rose);"></span>Exam-wise Performance</h3></div>
        <div style="height:270px;position:relative;"><canvas id="examChart2"></canvas></div>
      </div>
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;"><h3><span class="dot" style="background:var(--violet);"></span>Syllabus Completion</h3></div>
        @php $sp2 = $dashboard['syllabus_progress'] ?? 0; $R2 = 62; $C2 = round(2 * pi() * $R2, 1); $OFF2 = round($C2 * (1 - $sp2 / 100), 1); @endphp
        <div class="ring-wrapper" style="padding-top:10px;">
          <div class="ring-container" style="width:170px;height:170px;">
            <svg viewBox="0 0 170 170" width="170" height="170">
              <defs><linearGradient id="rg2" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#4338ca"/><stop offset="100%" stop-color="#be123c"/></linearGradient></defs>
              <circle cx="85" cy="85" r="{{ $R2 }}" fill="none" stroke="#e2e8f4" stroke-width="14"/>
              <circle cx="85" cy="85" r="{{ $R2 }}" fill="none" stroke="url(#rg2)" stroke-width="14" stroke-linecap="round" stroke-dasharray="{{ $C2 }}" stroke-dashoffset="{{ $OFF2 }}" style="transition:stroke-dashoffset .9s ease;"/>
            </svg>
            <div class="ring-inner">
              <div class="ring-pct" style="font-size:34px;color:var(--indigo);">{{ $sp2 }}%</div>
              <div class="ring-subtext">Done</div>
            </div>
          </div>
          <div class="ring-stats" style="gap:30px;">
            <div class="rs"><div class="rv" style="color:var(--emerald);">{{ number_format($dashboard['completed_chapters'] ?? 0) }}</div><div class="rl">Completed</div></div>
            <div class="rs"><div class="rv" style="color:var(--rose);">{{ number_format(($dashboard['chapters'] ?? 0) - ($dashboard['completed_chapters'] ?? 0)) }}</div><div class="rl">Remaining</div></div>
            <div class="rs"><div class="rv">{{ number_format($dashboard['chapters'] ?? 0) }}</div><div class="rl">Total</div></div>
          </div>
        </div>
      </div>
    </div>

    <div class="chart-row cr-5050">
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;"><h3><span class="dot" style="background:var(--cyan);"></span>Subject-wise Marks Entries</h3></div>
        <div class="sw-list">
          @foreach($subjectMarks ?? [] as $si => $sm)
          <div class="sw-row">
            <div class="sw-lbl" title="{{ $sm->subject_name ?? '' }}">{{ $sm->subject_name ?? '' }}</div>
            <div class="sw-track">
              <div class="sw-fill" style="width:{{ round((($sm->total_entries ?? 0) / $sjMax) * 100) }}%;background:{{ $sCols[$si % count($sCols)] }};">
                <span>{{ $sm->total_entries ?? 0 }}</span>
              </div>
            </div>
            <div class="sw-cnt">{{ $sm->total_entries ?? 0 }}</div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;"><h3><span class="dot" style="background:var(--indigo);"></span>Monthly Marks Activity</h3></div>
        <div style="height:260px;position:relative;"><canvas id="marksMonthly"></canvas></div>
      </div>
    </div>
  </div>{{-- /tab-academic --}}

  {{-- ────── TAB: PEOPLE ────── --}}
  <div class="tab-pane" id="tab-people">

    <div class="mc4" style="margin-bottom:22px;">
      @php $pCards=[
        ['l'=>'Active Students',   'v'=>$dashboard['active_students'] ?? 0,   'ico'=>'fa-user-graduate',      'c'=>'bc-indigo'],
        ['l'=>'Inactive Students', 'v'=>$dashboard['inactive_students'] ?? 0, 'ico'=>'fa-user-slash',         'c'=>'bc-amber'],
        ['l'=>'Total Teachers',    'v'=>$dashboard['teachers'] ?? 0,          'ico'=>'fa-chalkboard-teacher', 'c'=>'bc-emerald'],
        ['l'=>'Assigned Teachers', 'v'=>$dashboard['teacher_assigned'] ?? 0,  'ico'=>'fa-user-check',         'c'=>'bc-rose'],
      ]; @endphp
      @foreach($pCards as $pc)
      <div class="bcard {{ $pc['c'] }}">
        <div class="bc-head"><div class="bc-icon"><i class="fas {{ $pc['ico'] }}"></i></div></div>
        <div class="bc-num">{{ number_format($pc['v']) }}</div>
        <div class="bc-lbl">{{ $pc['l'] }}</div>
      </div>
      @endforeach
    </div>

    <div class="chart-row cr-3col">
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;"><h3><span class="dot" style="background:var(--violet);"></span>Gender Distribution</h3></div>
        <div class="gender-split" style="margin-bottom:8px;">
          <div class="gblock male">
            <div class="gb-icon"><i class="fas fa-mars"></i></div>
            <div class="gb-val">{{ number_format($dashboard['male_students'] ?? 0) }}</div>
            <div class="gb-lbl">Male Students</div>
            <div class="gb-pct">{{ $mPct ?? 0 }}% of gendered</div>
          </div>
          <div class="gblock female">
            <div class="gb-icon"><i class="fas fa-venus"></i></div>
            <div class="gb-val">{{ number_format($dashboard['female_students'] ?? 0) }}</div>
            <div class="gb-lbl">Female Students</div>
            <div class="gb-pct">{{ $fPct ?? 0 }}% of gendered</div>
          </div>
        </div>
        @if(($dashboard['gender_unknown_students'] ?? 0) > 0)
        <div class="gender-note"><i class="fas fa-info-circle"></i> {{ number_format($dashboard['gender_unknown_students'] ?? 0) }} students: gender not filled</div>
        @endif
        <div style="height:120px;position:relative;margin-top:10px;"><canvas id="genderDonut2"></canvas></div>
      </div>
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;"><h3><span class="dot" style="background:var(--emerald);"></span>Grade-wise Students</h3></div>
        <div class="sw-list" style="max-height:280px;overflow-y:auto;">
          @php $gMax = ($gradeDistribution ?? collect())->max('total') ?: 1; @endphp
          @foreach($gradeDistribution ?? [] as $gi => $gd)
          <div class="sw-row">
            <div class="sw-lbl">{{ $gd->grade_name ?? '' }}</div>
            <div class="sw-track">
              <div class="sw-fill" style="width:{{ round(($gd->total ?? 0) / $gMax * 100) }}%;background:{{ $swCols[$gi % count($swCols)] }};">
                <span>{{ $gd->total ?? 0 }}</span>
              </div>
            </div>
            <div class="sw-cnt">{{ $gd->total ?? 0 }}</div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="cpanel">
        <div class="panel-hdr" style="margin-bottom:14px;"><h3><span class="dot" style="background:var(--indigo);"></span>Monthly New Enrollments</h3></div>
        <div style="height:240px;position:relative;"><canvas id="studentsMonthly"></canvas></div>
      </div>
    </div>

    {{-- Activity Heatmap (FIXED: CSS class added + proper grid) --}}
    <div class="cpanel" style="margin-bottom:22px;">
      <div class="panel-hdr" style="margin-bottom:16px;">
        <h3><span class="dot" style="background:var(--amber);"></span>Activity Heatmap — {{ date('Y') }}</h3>
      </div>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;font-size:11px;color:var(--text3);font-weight:700;">
        @php $months=['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC']; @endphp
        @foreach($months as $mo)<span>{{ $mo }}</span>@endforeach
      </div>
      <div class="heatmap-g" id="heatmapGrid"></div>
      <div style="display:flex;align-items:center;gap:6px;margin-top:12px;font-size:11px;color:var(--text3);">
        <span>Less</span>
        <div style="width:14px;height:14px;border-radius:3px;background:#e2e8f4;"></div>
        <div style="width:14px;height:14px;border-radius:3px;background:#c7d2fe;"></div>
        <div style="width:14px;height:14px;border-radius:3px;background:#818cf8;"></div>
        <div style="width:14px;height:14px;border-radius:3px;background:#4338ca;"></div>
        <div style="width:14px;height:14px;border-radius:3px;background:#312e81;"></div>
        <span>More</span>
      </div>
    </div>

    <div class="t2col">
      <div class="tpanel">
        <div class="tpanel-hdr"><h3><i class="fas fa-user-graduate"></i> Students List</h3><a href="{{ url('admin/student-list') }}">View all →</a></div>
        <table class="etbl">
          <thead><tr><th>Student</th><th>No.</th><th>Grade</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($recentStudents ?? [] as $s)
            @php $n=trim(($s->first_name??'').' '.($s->middle_name??'').' '.($s->last_name??''))?:'Student'; $ini=strtoupper(substr($s->first_name??'',0,1).substr($s->last_name??'',0,1)); $bg=$aBgs[crc32($s->id??'')%count($aBgs)]; @endphp
            <tr>
              <td><div style="display:flex;align-items:center;"><span class="ava" style="background:{{ $bg }}">{{ $ini }}</span><a href="{{ url('admin/student-edit/'.($s->id??'')) }}">{{ $n }}</a></div></td>
              <td style="font-family:var(--mono);font-size:12px;">{{ $s->admission_no??'-' }}</td>
              <td>{{ $s->grade_name??'-' }}</td>
              <td><span class="status-pill {{ ($s->status??'')==='Active'?'sp-active':'sp-inactive' }}">{{ $s->status??'-' }}</span></td>
            </tr>
            @empty<tr class="etbl-empty"><td colspan="4">No students found.</td></tr>@endforelse
          </tbody>
        </table>
      </div>
      <div class="tpanel">
        <div class="tpanel-hdr"><h3><i class="fas fa-chalkboard-teacher"></i> Teachers List</h3><a href="{{ url('admin/teacher') }}">View all →</a></div>
        <table class="etbl">
          <thead><tr><th>Teacher</th><th>ID</th><th>Gender</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($recentTeachers ?? [] as $t)
            @php $tIni=strtoupper(substr($t->name??'',0,2)); $tBg=$tBgs[crc32($t->id_hash??'')%count($tBgs)]; @endphp
            <tr>
              <td><div style="display:flex;align-items:center;"><span class="ava" style="background:{{ $tBg }}">{{ $tIni }}</span><a href="{{ url('admin/edit-teacher/'.($t->id_hash??'')) }}">{{ $t->name??'-' }}</a></div></td>
              <td style="font-family:var(--mono);font-size:12px;">{{ $t->teacher_id??'-' }}</td>
              <td>{{ $t->gender??'-' }}</td>
              <td><span class="status-pill {{ ($t->status??'')==='Active'?'sp-active':'sp-neutral' }}">{{ $t->status??'-' }}</span></td>
            </tr>
            @empty<tr class="etbl-empty"><td colspan="4">No teachers found.</td></tr>@endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>{{-- /tab-people --}}

@endif
</div>{{-- /.erp-body --}}
</div>{{-- /.content-wrapper --}}
</div>{{-- /.erpd --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
/* ══════════ DATA FROM BLADE ══════════ */
const MONTHLY_STUDENTS  = @json($monthly_students  ?? array_fill(0, 12, 0));
const MONTHLY_MARKS     = @json($monthly_marks     ?? array_fill(0, 12, 0));
const MONTHLY_TRANSFERS = @json($monthly_transfers ?? array_fill(0, 12, 0));

const GRADE_LABELS = @json(($gradeDistribution ?? collect())->pluck('grade_name'));
const GRADE_DATA   = @json(($gradeDistribution ?? collect())->pluck('total'));

@php
$examPerf = $examPerformance ?? collect();
$epL  = $examPerf->map(fn($e) => $e->exam_name ?? '')->toArray();
// FIX: Safe division — avg_max may be 0
$epAv = $examPerf->map(fn($e) => (($e->avg_max ?? 0) > 0) ? round(($e->avg_marks / $e->avg_max) * 100, 1) : 0)->toArray();
$epCt = $examPerf->map(fn($e) => $e->student_count ?? 0)->toArray();
@endphp
const EP_LABELS = @json($epL);
const EP_AVG    = @json($epAv);
const EP_COUNT  = @json($epCt);

const GENDER_DATA = {
  ms: {{ $genderData['male_students']   ?? 0 }},
  fs: {{ $genderData['female_students'] ?? 0 }},
  mt: {{ $genderData['male_teachers']   ?? 0 }},
  ft: {{ $genderData['female_teachers'] ?? 0 }},
};

const M_LABELS   = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const MONTHS_FULL = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const DAYS_FULL   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

const CHART_FONT = "'Plus Jakarta Sans',sans-serif";
const TOOLTIP_BG = '#0a1628';

/* ══════════ CLOCK ══════════ */
function pad2(n){ return String(n).padStart(2,'0'); }
function updateClock(){
  const now = new Date();
  const el = document.getElementById('clockTime');
  if(el) el.innerHTML = pad2(now.getHours())+'<span class="sep">:</span>'+pad2(now.getMinutes())+'<span class="sep">:</span>'+pad2(now.getSeconds());
  const d = document.getElementById('clockDay');
  if(d) d.textContent = DAYS_FULL[now.getDay()].toUpperCase();
  const dt = document.getElementById('clockDate');
  if(dt) dt.textContent = MONTHS_FULL[now.getMonth()]+' '+now.getDate()+', '+now.getFullYear();
  const h = now.getHours();
  const greet = h < 12 ? 'Good Morning 🌤️' : h < 17 ? 'Good Afternoon ☀️' : 'Good Evening 🌙';
  const hg = document.getElementById('hdrGreet');
  if(hg) hg.textContent = greet + ' — {{ $user->name }}';
  const ts = document.getElementById('todayStr');
  if(ts) ts.textContent = 'Real-time tracking for ' + DAYS_FULL[now.getDay()] + ', ' + MONTHS_FULL[now.getMonth()] + ' ' + now.getDate() + ', ' + now.getFullYear();
}
updateClock();
setInterval(updateClock, 1000);

/* ══════════ TAB SWITCHING ══════════ */
document.querySelectorAll('.hnav-tab').forEach(function(tab){
  tab.addEventListener('click', function(){
    document.querySelectorAll('.hnav-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    this.classList.add('active');
    const pane = document.getElementById('tab-' + this.dataset.tab);
    if(pane){ pane.classList.add('active'); buildTabCharts(this.dataset.tab); }
  });
});

/* ══════════ SEARCH ══════════ */
const srchInput = document.getElementById('srchInput');
const srchDrop  = document.getElementById('srchDrop');
const micBtn    = document.getElementById('micBtn');

if(srchInput && srchDrop){
  function showDrop(items){
    srchDrop.innerHTML = ''; srchDrop.style.display = 'block';
    if(!items.length){
      srchDrop.innerHTML = '<div class="sdrop-item" style="color:var(--text3)">No results</div>'; return;
    }
    items.forEach(function(item){
      const d = document.createElement('div'); d.className = 'sdrop-item';
      d.innerHTML = '<span class="sdrop-tag '+item.type.toLowerCase().slice(0,2)+'">'+item.type+'</span><span class="sdrop-name">'+item.name+'</span>';
      d.addEventListener('click', function(){ window.location.href = item.url; });
      srchDrop.appendChild(d);
    });
  }
  srchInput.addEventListener('input', function(){
    const q = this.value.trim();
    if(q.length < 2){ srchDrop.style.display = 'none'; return; }
    fetch('{{ url("admin/voice-search") }}?query=' + encodeURIComponent(q))
      .then(r => r.json()).then(showDrop).catch(() => { srchDrop.style.display = 'none'; });
  });
  document.addEventListener('click', function(e){ if(!e.target.closest('.hdr-search')) srchDrop.style.display = 'none'; });

  if(micBtn){
    const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
    if(SR){
      const rec = new SR(); rec.lang = 'en-IN'; rec.interimResults = false;
      micBtn.addEventListener('click', function(){ rec.start(); this.style.background = '#be123c'; });
      rec.onresult = function(e){ srchInput.value = e.results[0][0].transcript; srchInput.dispatchEvent(new Event('input')); micBtn.style.background = ''; };
      rec.onerror  = function(){ micBtn.style.background = ''; };
    }
  }
}

/* ══════════ CHART FACTORY ══════════ */
const _built = {};
const chartInstances = {};

function buildTabCharts(tab){
  if(_built[tab]) return; _built[tab] = true;

  function getCtx(id){
    const el = document.getElementById(id); if(!el) return null;
    if(chartInstances[id]){ chartInstances[id].destroy(); delete chartInstances[id]; }
    return el.getContext('2d');
  }

  const defOpts = {
    responsive: true, maintainAspectRatio: false,
    plugins:{
      legend:{ position:'bottom', labels:{ font:{family:CHART_FONT,size:11}, boxWidth:12, padding:14 } },
      tooltip:{ backgroundColor:TOOLTIP_BG, padding:10, bodyFont:{family:CHART_FONT,size:12}, titleFont:{family:CHART_FONT} }
    }
  };

  function mkMonthly(id){
    const ctx = getCtx(id); if(!ctx) return;
    chartInstances[id] = new Chart(ctx,{
      type:'line',
      data:{ labels:M_LABELS, datasets:[
        { label:'New Students',  data:MONTHLY_STUDENTS,  borderColor:'#4338ca', backgroundColor:'rgba(67,56,202,.08)',  borderWidth:2.5, pointBackgroundColor:'#4338ca', pointRadius:4, fill:true, tension:.45 },
        { label:'Marks Updated', data:MONTHLY_MARKS,     borderColor:'#047857', backgroundColor:'rgba(4,120,87,.07)',   borderWidth:2.5, pointBackgroundColor:'#047857', pointRadius:4, fill:true, tension:.45 },
        { label:'TC Issued',     data:MONTHLY_TRANSFERS, borderColor:'#be123c', backgroundColor:'rgba(190,18,60,.05)',  borderWidth:2.5, pointBackgroundColor:'#be123c', pointRadius:4, fill:true, tension:.45 },
      ]},
      options:Object.assign({},defOpts,{
        interaction:{ mode:'index', intersect:false },
        scales:{
          x:{ grid:{display:false}, ticks:{font:{family:CHART_FONT,size:11}} },
          y:{ beginAtZero:true, grid:{color:'#f0f2f8'}, ticks:{precision:0,font:{family:CHART_FONT,size:11}} }
        }
      })
    });
  }

  function mkGender(id){
    const ctx = getCtx(id); if(!ctx) return;
    // FIX: Only show filled gender data. If all zero, show placeholder.
    const total = GENDER_DATA.ms + GENDER_DATA.fs + GENDER_DATA.mt + GENDER_DATA.ft;
    chartInstances[id] = new Chart(ctx,{
      type:'doughnut',
      data:{
        labels:['Male Students','Female Students','Male Teachers','Female Teachers'],
        datasets:[{
          data: total > 0
            ? [GENDER_DATA.ms, GENDER_DATA.fs, GENDER_DATA.mt, GENDER_DATA.ft]
            : [1, 0, 0, 0],
          backgroundColor:['#4338ca','#be123c','#0284c7','#b45309'],
          borderWidth:0, hoverOffset:8
        }]
      },
      options:Object.assign({},defOpts,{
        cutout:'68%',
        plugins:Object.assign({},defOpts.plugins,{
          legend:{ position:'bottom', labels:{ font:{family:CHART_FONT,size:10}, boxWidth:10, padding:8 } }
        })
      })
    });
  }

  function mkGradeBar(id){
    const ctx = getCtx(id); if(!ctx) return;
    const pal = ['#4338ca','#047857','#6d28d9','#b45309','#be123c','#0d9488','#c2410c','#0284c7','#9d174d','#0e7490','#16a34a','#7c3aed','#b91c1c','#0369a1'];
    chartInstances[id] = new Chart(ctx,{
      type:'bar',
      data:{ labels:GRADE_LABELS.length?GRADE_LABELS:['No Data'], datasets:[{ label:'Students', data:GRADE_DATA.length?GRADE_DATA:[0], backgroundColor:pal.slice(0,GRADE_LABELS.length||1), borderRadius:6, borderSkipped:false }] },
      options:Object.assign({},defOpts,{
        plugins:Object.assign({},defOpts.plugins,{ legend:{display:false} }),
        scales:{
          x:{ grid:{display:false}, ticks:{font:{family:CHART_FONT,size:10},maxRotation:35} },
          y:{ beginAtZero:true, grid:{color:'#f0f2f8'}, ticks:{precision:0,font:{family:CHART_FONT,size:11}} }
        }
      })
    });
  }

  function mkExam(id){
    const ctx = getCtx(id); if(!ctx) return;
    chartInstances[id] = new Chart(ctx,{
      type:'bar',
      data:{ labels:EP_LABELS.length?EP_LABELS:['No Exams'], datasets:[
        { label:'Avg Score %', data:EP_AVG.length?EP_AVG:[0],   backgroundColor:'rgba(190,18,60,.75)', borderRadius:6, borderSkipped:false, yAxisID:'y'  },
        { label:'Students',    data:EP_COUNT.length?EP_COUNT:[0], backgroundColor:'rgba(67,56,202,.6)',  borderRadius:6, borderSkipped:false, yAxisID:'y1' },
      ]},
      options:Object.assign({},defOpts,{
        interaction:{ mode:'index', intersect:false },
        scales:{
          x:{ grid:{display:false}, ticks:{font:{family:CHART_FONT,size:10},maxRotation:20} },
          y:{ beginAtZero:true, max:100, position:'left', grid:{color:'#f0f2f8'}, ticks:{callback:v=>v+'%',font:{family:CHART_FONT,size:11}} },
          y1:{ beginAtZero:true, position:'right', grid:{display:false}, ticks:{precision:0,font:{family:CHART_FONT,size:11}} }
        }
      })
    });
  }

  function mkMarksBar(id){
    const ctx = getCtx(id); if(!ctx) return;
    chartInstances[id] = new Chart(ctx,{
      type:'bar',
      data:{ labels:M_LABELS, datasets:[{ label:'Marks Added', data:MONTHLY_MARKS, backgroundColor:MONTHLY_MARKS.map((_,i)=>`hsla(${250+i*3},70%,55%,.8)`), borderRadius:6, borderSkipped:false }] },
      options:Object.assign({},defOpts,{
        plugins:Object.assign({},defOpts.plugins,{ legend:{display:false} }),
        scales:{ x:{grid:{display:false},ticks:{font:{family:CHART_FONT,size:11}}}, y:{beginAtZero:true,grid:{color:'#f0f2f8'},ticks:{precision:0,font:{family:CHART_FONT,size:11}}} }
      })
    });
  }

  function mkStudentsBar(id){
    const ctx = getCtx(id); if(!ctx) return;
    chartInstances[id] = new Chart(ctx,{
      type:'bar',
      data:{ labels:M_LABELS, datasets:[{ label:'New Students', data:MONTHLY_STUDENTS, backgroundColor:MONTHLY_STUDENTS.map((_,i)=>`hsla(${220+i*5},75%,55%,.8)`), borderRadius:6, borderSkipped:false }] },
      options:Object.assign({},defOpts,{
        plugins:Object.assign({},defOpts.plugins,{ legend:{display:false} }),
        scales:{ x:{grid:{display:false},ticks:{font:{family:CHART_FONT,size:11}}}, y:{beginAtZero:true,grid:{color:'#f0f2f8'},ticks:{precision:0,font:{family:CHART_FONT,size:11}}} }
      })
    });
  }

  if(tab === 'overview'){
    mkMonthly('monthlyChart');
    mkGender('genderDonut');
    mkGradeBar('gradeChart');
    mkExam('examChart');
  }
  if(tab === 'academic'){
    mkExam('examChart2');
    mkMarksBar('marksMonthly');
  }
  if(tab === 'people'){
    mkGender('genderDonut2');
    mkStudentsBar('studentsMonthly');
    buildHeatmap();
  }
}

/* ══════════ HEATMAP (FIXED) ══════════ */
function buildHeatmap(){
  const grid = document.getElementById('heatmapGrid'); if(!grid) return;
  const combined = MONTHLY_STUDENTS.map((v,i) => v + (MONTHLY_MARKS[i]||0));
  const maxV = Math.max(...combined, 1);
  const palette = ['#e2e8f4','#c7d2fe','#818cf8','#4338ca','#312e81'];
  const monthsF = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  grid.innerHTML = '';
  for(let m = 0; m < 12; m++){
    const val = combined[m] || 0;
    const lvl = val === 0 ? 0 : Math.min(4, Math.ceil((val / maxV) * 4));
    const cell = document.createElement('div');
    cell.className = 'hm-cell';
    cell.style.background = palette[lvl];
    cell.innerHTML = '<div class="hm-tooltip">'+monthsF[m]+': '+(MONTHLY_STUDENTS[m]||0)+' students, '+(MONTHLY_MARKS[m]||0)+' marks</div>';
    grid.appendChild(cell);
  }
}

/* ══════════ INIT ══════════ */
document.addEventListener('DOMContentLoaded', function(){
  @if(!$isTeacher)
  buildTabCharts('overview');
  @endif
});
</script>
@endsection
