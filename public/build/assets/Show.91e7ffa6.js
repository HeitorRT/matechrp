import{_ as g}from"./AuthenticatedLayout.56960ce8.js";import{_ as q}from"./Index.5b66d98f.js";import{m as b,n,a as l,b as k,w as h,F as _,r as d,o as s,H as E,d as t,s as p,t as o,p as y,c as C}from"./app.cc606831.js";import"./AdminDialog.1d33fa88.js";const L={class:"student-container-responsive",style:{"margin-top":"140px"}},N={class:"row"},$={key:0,class:"col-12"},B=["innerHTML"],H={class:"col-12 col-md-5 q-mt-xl"},M=t("div",{class:"student-text-purple app-fw-800 app-fs-12 app-lh-16 q-mb-md student-label-category-carrousel"}," Live ",-1),D={class:"text-white app-fw-800 app-fs-58 app-lh-72 q-mb-lg"},V={class:"text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg"},j={key:0,class:"q-mt-xl"},A=t("div",{class:"text-white app-fw-700 app-fs-27 app-lh-22 q-mb-lg"}," Conte\xFAdo vinculado ",-1),F={class:"text-white app-fw-700 app-fs-23 app-lh-22 q-my-lg"},S={class:"text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg"},T={class:"text-white app-fw-400 app-fs-19 app-lh-24 row justify-between"},z={key:0},O={key:1},G={key:1,class:"q-mt-xl"},I=t("div",{class:"text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg"}," N\xE3o h\xE1 conte\xFAdo vinculado ",-1),J=[I],K=t("div",{class:"col-12 col-md-7"},null,-1),P=t("div",{class:"text-white app-fw-700 app-fs-27 app-lh-22 q-mt-xl q-mb-md"}," Materiais da live ",-1),Q={class:"row"},R={class:"col-md-3 col-12"},U={key:1,class:"app-br-16 flex flex-center",style:{"max-width":"90%",height:"162px",border:"1px dashed grey"}},W={class:"text-white app-fw-700 app-fs-22 app-lh-32 q-py-md"},X=["onClick"],Y={key:0,class:"col-12"},Z=t("div",{class:"text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg"}," N\xE3o h\xE1 materiais disponiveis ",-1),tt=[Z],at={__name:"Show",props:{liveEvent:Object},setup(e){const v=b(!1),f=(r,c="material")=>{const a=document.createElement("a");a.href=r,a.target="_blank",a.setAttribute("download",c),a.click()};return(r,c)=>{const a=d("q-img"),u=d("q-icon"),w=d("q-card-section"),x=d("q-card");return s(),n(_,null,[l(k(E),{title:`Assistir ${e.liveEvent.name}`},null,8,["title"]),l(g,null,{default:h(()=>{var m;return[t("div",L,[t("div",N,[e.liveEvent.embed?(s(),n("div",$,[t("div",{innerHTML:e.liveEvent.embed,class:"app-player-iframe"},null,8,B)])):p("",!0),t("div",H,[M,t("div",D,o(e.liveEvent.name),1),t("div",V,o(e.liveEvent.description),1),e.liveEvent.has_link_with_content?(s(),n("div",j,[A,l(a,{class:"app-br-16 cursor-pointer",src:e.liveEvent.content.image,height:"256px",onClick:c[0]||(c[0]=i=>v.value=!0)},null,8,["src"]),t("div",F,o(e.liveEvent.content.name),1),t("div",S,o(e.liveEvent.content.description),1),t("div",T,[t("div",null," Dire\xE7\xE3o: "+o(e.liveEvent.content.responsible_name),1),e.liveEvent.content.count_seasons?(s(),n("div",z,o(e.liveEvent.content.count_seasons)+" temporadas ",1)):(s(),n("div",O,o((m=e.liveEvent.content.chapter)==null?void 0:m.duration),1))]),l(q,{content:e.liveEvent.content,show:v.value,onClose:c[1]||(c[1]=i=>v.value=i)},null,8,["content","show"])])):p("",!0),e.liveEvent.has_link_with_content?p("",!0):(s(),n("div",G,J))]),K]),P,t("div",Q,[(s(!0),n(_,null,y(e.liveEvent.materials,i=>(s(),n("div",R,[l(x,{class:"transparent full-height",flat:""},{default:h(()=>[l(w,{class:"q-px-none"},{default:h(()=>[i.is_image?(s(),C(a,{key:0,class:"app-br-16",src:i.link,height:"162px",style:{"max-width":"90"}},null,8,["src"])):(s(),n("div",U,[l(u,{name:"folder",size:"80px",color:"grey"})])),t("div",W,o(i.name),1),t("div",{class:"text-white app-fw-400 app-fs-16 app-lh-24 app-text-with-underline cursor-pointer",onClick:et=>f(i.link,i.name)}," Download ",8,X)]),_:2},1024)]),_:2},1024)]))),256)),e.liveEvent.materials.length===0?(s(),n("div",Y,tt)):p("",!0)])])]}),_:1})],64)}}};export{at as default};
