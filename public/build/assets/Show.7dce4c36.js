import{_ as g}from"./AuthenticatedLayout.0bc0b363.js";import{u as r,c as q,w as n,r as c,o as h,a,b as t,H as x,d as e}from"./app.cc606831.js";const v={class:"row q-mb-lg"},V={class:"column col-12 col-md-6 justify-center"},y=e("div",{class:"app-fs-28 app-fw-700 app-lh-32 text-grey-8"}," Campanha ",-1),w={class:"col-12 col-md-6 flex justify-end items-center"},C=e("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Voltar ",-1),k={class:"bg-white q-py-lg q-px-lg app-br-16"},j={class:"row q-col-gutter-lg"},B=e("div",{class:"col-12 items-center q-mt-xs"},[e("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Informa\xE7\xF5es ")],-1),z={class:"col-12 col-md-12"},H={class:"col-12 col-md-6"},N={class:"col-12 col-md-6"},F={__name:"Show",props:{campaign:Object,errors:Object},setup(_){const d=_,s=r({id:d.campaign.id,name:d.campaign.name,start_at:d.campaign.start_at,end_at:d.campaign.end_at}),u=()=>r().get(route("admin.meeting.index"));return(U,o)=>{const m=c("q-breadcrumbs-el"),b=c("q-breadcrumbs"),i=c("q-icon"),f=c("q-btn"),p=c("q-input");return h(),q(g,null,{default:n(()=>[a(t(x),{title:"Campanha | Visualizar"}),e("div",v,[e("div",V,[y,a(b,{class:"text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16",gutter:"xs"},{default:n(()=>[a(m,{label:"Home",class:"text-grey"}),a(m,{label:"Campanha",class:"text-grey"}),a(m,{label:"Visualizar Campanha",class:"text-primary"})]),_:1})]),e("div",w,[a(f,{color:"primary",class:"q-mr-md",rounded:"","no-caps":"",outline:"",onClick:u},{default:n(()=>[a(i,{name:"chevron_left",size:"xs"}),C]),_:1})])]),e("div",k,[e("div",j,[B,e("div",z,[a(p,{outlined:"",modelValue:t(s).name,"onUpdate:modelValue":o[0]||(o[0]=l=>t(s).name=l),label:"Nome",disable:""},null,8,["modelValue"])]),e("div",H,[a(p,{outlined:"",modelValue:t(s).start_at,"onUpdate:modelValue":o[1]||(o[1]=l=>t(s).start_at=l),mask:"##/##/####",label:"Data de inicio",disable:""},{prepend:n(()=>[a(i,{name:"o_calendar_today"})]),_:1},8,["modelValue"])]),e("div",N,[a(p,{outlined:"",modelValue:t(s).end_at,"onUpdate:modelValue":o[2]||(o[2]=l=>t(s).end_at=l),mask:"##/##/####",label:"Data final",disable:""},{prepend:n(()=>[a(i,{name:"o_calendar_today"})]),_:1},8,["modelValue"])])])])]),_:1})}}};export{F as default};
