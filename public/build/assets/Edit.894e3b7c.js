import{_ as S}from"./AuthenticatedLayout.0bc0b363.js";import{h as E,u as x,c as g,w as n,r as a,o as i,a as s,b as o,H as j,d as e,s as r,n as f,t as y}from"./app.cc606831.js";import{_ as C}from"./DialogConfirm.f96873bf.js";import{d as B}from"./vuedraggable.umd.00a30f46.js";const z={class:"row q-mb-lg"},N={class:"column col-12 col-md-6 justify-center"},H=e("div",{class:"app-fs-28 app-fw-700 app-lh-32 text-grey-8"}," Editar se\xE7\xE3o ",-1),O={class:"col-12 col-md-6 flex justify-end items-center"},$=e("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Excluir se\xE7\xE3o ",-1),D=e("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Salvar ",-1),I={class:"bg-white q-py-lg q-px-lg app-br-16"},U={class:"row q-col-gutter-lg"},A=e("div",{class:"col-12 items-center q-mt-xs"},[e("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Informa\xE7\xF5es ")],-1),F={key:0,class:"col-12 col-md-12"},P={class:"col-12 col-md-12"},Q={class:"text-red"},G={key:1,class:"col-12 items-center q-mt-xs"},J=e("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Conte\xFAdos ",-1),K=[J],L={key:2,class:"col-12"},M={class:"text-center",style:{width:"10%"}},R={class:"text-left",style:{padding:"0",width:"10%"}},T={class:"text-left"},te={__name:"Edit",props:{section:Object,errors:Object},setup(m){const l=m,p=E(),t=x({id:l.section.id,name:l.section.name,identifier:l.section.identifier,can_delete:l.section.can_delete,contents:l.section.contents}),q=()=>{t.put(route("admin.section.update",t.id),{onSuccess:()=>{p.notify({type:"positive",message:"Se\xE7\xE3o atualizado com sucesso",position:"top"})}})};function v(){p.dialog({component:C,componentProps:{title:"Excluir se\xE7\xE3o",message:"Ao excluir a se\xE7\xE3o, todos os v\xEDnculos com conte\xFAdos ser\xE3o desfeitos. Deseja realmente excluir?"}}).onOk(()=>{x().delete(route("admin.section.destroy",t.id),{onSuccess:()=>{p.notify({type:"positive",message:"Se\xE7\xE3o exclu\xEDda com sucesso",position:"top"})}})})}return(W,d)=>{const _=a("q-breadcrumbs-el"),k=a("q-breadcrumbs"),u=a("q-icon"),h=a("q-btn"),b=a("q-input"),w=a("q-img"),V=a("q-markup-table");return i(),g(S,null,{default:n(()=>[s(o(j),{title:"Se\xE7\xE3o | Editar"}),e("div",z,[e("div",N,[H,s(k,{class:"text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16",gutter:"xs"},{default:n(()=>[s(_,{label:"Home",class:"text-grey"}),s(_,{label:"Se\xE7\xF5es",class:"text-grey"}),s(_,{label:"Editar se\xE7\xE3o",class:"text-primary"})]),_:1})]),e("div",O,[o(t).can_delete?(i(),g(h,{key:0,color:"negative",class:"q-mr-md",rounded:"","no-caps":"",outline:"",onClick:v},{default:n(()=>[s(u,{name:"close",size:"xs"}),$]),_:1})):r("",!0),s(h,{color:"primary",rounded:"","no-caps":"",onClick:q,disabled:o(t).processing},{default:n(()=>[s(u,{name:"check",size:"xs"}),D]),_:1},8,["disabled"])])]),e("div",I,[e("div",U,[A,o(t).identifier?(i(),f("div",F,[s(b,{outlined:"",modelValue:o(t).identifier,"onUpdate:modelValue":d[0]||(d[0]=c=>o(t).identifier=c),label:"Identificador",disable:""},null,8,["modelValue"])])):r("",!0),e("div",P,[s(b,{outlined:"",modelValue:o(t).name,"onUpdate:modelValue":d[1]||(d[1]=c=>o(t).name=c),label:"Nome *","bottom-slots":Boolean(m.errors.name)},{hint:n(()=>[e("div",Q,y(m.errors.name),1)]),_:1},8,["modelValue","bottom-slots"])]),o(t).contents.length>0?(i(),f("div",G,K)):r("",!0),o(t).contents.length>0?(i(),f("div",L,[s(V,{class:"text-grey-8",flat:"",dense:""},{default:n(()=>[e("tbody",null,[s(o(B),{list:o(t).contents,"item-key":"index"},{item:n(({element:c,index:X})=>[e("tr",null,[e("td",M,[s(u,{name:"subject",size:"sm",class:"cursor-pointer"})]),e("td",R,[s(w,{src:c.image,style:{height:"56px",width:"176px"}},null,8,["src"])]),e("td",T,y(c.name),1)])]),_:1},8,["list"])])]),_:1})])):r("",!0)])])]),_:1})}}};export{te as default};
