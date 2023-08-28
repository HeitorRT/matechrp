import{_ as C}from"./AuthenticatedLayout.0bc0b363.js";import{h as D,u as v,c as y,w as t,r as c,i as j,o as q,a as e,b as s,H as Y,d as a,s as B,t as f,e as x}from"./app.cc606831.js";import{_ as E}from"./DialogConfirm.f96873bf.js";const O={class:"row q-mb-lg"},U={class:"column col-12 col-md-6 justify-center"},H=a("div",{class:"app-fs-28 app-fw-700 app-lh-32 text-grey-8"}," Campanha ",-1),M={class:"col-12 col-md-6 flex justify-end items-center"},N=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Excluir campanha ",-1),S=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Salvar ",-1),$={class:"bg-white q-py-lg q-px-lg app-br-16"},z={class:"row q-col-gutter-lg"},F=a("div",{class:"col-12 items-center q-mt-xs"},[a("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Informa\xE7\xF5es ")],-1),I={class:"col-12 col-md-12"},P={class:"text-red"},Q={class:"col-12 col-md-6"},A={class:"text-red"},G={class:"row items-center justify-end"},J={class:"col-12 col-md-6"},K={class:"text-red"},L={class:"row items-center justify-end"},Z={__name:"Edit",props:{campaign:Object,errors:Object,canCampaignDestroy:Boolean},setup(d){const i=d,p=D(),o=v({id:i.campaign.id,name:i.campaign.name,start_at:i.campaign.start_at,end_at:i.campaign.end_at}),V=()=>{o.put(route("admin.campaign.update",o.id),{onSuccess:()=>{p.notify({type:"positive",message:"Campanha atualizado com sucesso",position:"top"})}})};function k(){p.dialog({component:E,componentProps:{title:"Excluir campanha",message:i.campaign.orders_count>0?`H\xE1 ${i.campaign.orders_count} pedidos vinculados a esta campanha. Deseja realmente excluir?`:"Deseja realmente excluir?"}}).onOk(()=>{v().delete(route("admin.campaign.destroy",o.id),{onSuccess:()=>{p.notify({type:"positive",message:"Campanha exclu\xEDdo com sucesso",position:"top"})}})})}return(R,l)=>{const u=c("q-breadcrumbs-el"),w=c("q-breadcrumbs"),r=c("q-icon"),m=c("q-btn"),_=c("q-input"),b=c("q-date"),g=c("q-popup-proxy"),h=j("close-popup");return q(),y(C,null,{default:t(()=>[e(s(Y),{title:"Campanha | Editar"}),a("div",O,[a("div",U,[H,e(w,{class:"text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16",gutter:"xs"},{default:t(()=>[e(u,{label:"Home",class:"text-grey"}),e(u,{label:"Campanha",class:"text-grey"}),e(u,{label:"Editar Campanha",class:"text-primary"})]),_:1})]),a("div",M,[d.canCampaignDestroy?(q(),y(m,{key:0,color:"negative",class:"q-mr-md",rounded:"","no-caps":"",outline:"",onClick:k},{default:t(()=>[e(r,{name:"close",size:"xs"}),N]),_:1})):B("",!0),e(m,{color:"primary",rounded:"","no-caps":"",onClick:V,disabled:s(o).processing},{default:t(()=>[e(r,{name:"check",size:"xs"}),S]),_:1},8,["disabled"])])]),a("div",$,[a("div",z,[F,a("div",I,[e(_,{outlined:"",modelValue:s(o).name,"onUpdate:modelValue":l[0]||(l[0]=n=>s(o).name=n),label:"Nome *","bottom-slots":Boolean(d.errors.name)},{hint:t(()=>[a("div",P,f(d.errors.name),1)]),_:1},8,["modelValue","bottom-slots"])]),a("div",Q,[e(_,{outlined:"",modelValue:s(o).start_at,"onUpdate:modelValue":l[2]||(l[2]=n=>s(o).start_at=n),mask:"##/##/####",label:"Data de inicio","bottom-slots":Boolean(d.errors.start_at),clearable:""},{prepend:t(()=>[e(r,{name:"o_calendar_today"})]),hint:t(()=>[a("div",A,f(d.errors.start_at),1)]),default:t(()=>[e(g,null,{default:t(()=>[e(b,{modelValue:s(o).start_at,"onUpdate:modelValue":l[1]||(l[1]=n=>s(o).start_at=n),mask:"DD/MM/YYYY",square:""},{default:t(()=>[a("div",G,[x(e(m,{label:"Ok",color:"primary",flat:""},null,512),[[h]])])]),_:1},8,["modelValue"])]),_:1})]),_:1},8,["modelValue","bottom-slots"])]),a("div",J,[e(_,{outlined:"",modelValue:s(o).end_at,"onUpdate:modelValue":l[4]||(l[4]=n=>s(o).end_at=n),mask:"##/##/####",label:"Data final","bottom-slots":Boolean(d.errors.end_at),clearable:""},{prepend:t(()=>[e(r,{name:"o_calendar_today"})]),hint:t(()=>[a("div",K,f(d.errors.end_at),1)]),default:t(()=>[e(g,null,{default:t(()=>[e(b,{modelValue:s(o).end_at,"onUpdate:modelValue":l[3]||(l[3]=n=>s(o).end_at=n),mask:"DD/MM/YYYY",square:""},{default:t(()=>[a("div",L,[x(e(m,{label:"Ok",color:"primary",flat:""},null,512),[[h]])])]),_:1},8,["modelValue"])]),_:1})]),_:1},8,["modelValue","bottom-slots"])])])])]),_:1})}}};export{Z as default};
