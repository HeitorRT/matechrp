import{_ as L}from"./AuthenticatedLayout.0bc0b363.js";import{h as N,u as C,j as O,m as F,c as H,w as a,r as i,o as g,a as s,b as t,H as S,d as e,t as b,f,n as w,B as V,C as B,D as k}from"./app.cc606831.js";import{u as $}from"./index.common.8f199d34.js";const T={class:"row q-mb-lg"},E={class:"column col-12 col-md-6 justify-center"},Q=e("div",{class:"app-fs-28 app-fw-700 app-lh-32 text-grey-8"}," Adicionar brinde ",-1),X={class:"bg-white q-py-lg q-px-lg app-br-16"},Z={class:"row q-col-gutter-lg"},G=e("div",{class:"col-12 items-center q-mt-xs"},[e("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Informa\xE7\xF5es ")],-1),J={class:"col-12 col-md-6"},K={class:"text-red"},M={class:"col-12 col-md-6"},W={class:"text-red"},Y={class:"col-12 col-md-12"},ee={class:"text-red"},se={class:"col-12 items-center q-mt-xs"},oe={class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"},te={key:0,class:"col-12 col-md-6"},ae={class:"absolute-bottom text-subtitle2 row items-center"},ne={key:1,class:"col-12"},le=e("div",{class:"q-mt-sm"}," Clique aqui ou arraste sua imagem ",-1),ie={class:"col-12 flex justify-end items-center"},ce=e("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Voltar ",-1),re=e("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Criar brinde ",-1),_e={__name:"Create",props:{item:Object,errors:Object,campaigns:Array},setup(c){const h=c,x=N(),o=C({id:null,name:null,description:null,campaign_id:null,image:null}),m=$({onDrop:(d,n)=>{o.image=d[0],n.length>0&&x.notify({message:"Insira apenas uma imagem",position:"center"})},accept:["image/*"],maxFiles:1}),q=O(()=>o.image?typeof o.image=="object"?URL.createObjectURL(o.image):o.image:""),z=()=>o.image=null,I=()=>{o.post(route("admin.item.store"),{onSuccess:()=>{x.notify({type:"positive",message:"Brinde cadastrado com sucesso",position:"top"})}})},v=F(h.campaigns),j=(d,n,p)=>{n(()=>v.value=h.campaigns.filter(u=>u.name.toLowerCase().indexOf(d.toLowerCase())>-1))},P=()=>C().get(route("admin.item.index"));return(d,n)=>{const p=i("q-breadcrumbs-el"),u=i("q-breadcrumbs"),y=i("q-input"),r=i("q-icon"),A=i("q-chip"),D=i("q-select"),R=i("q-tooltip"),_=i("q-btn"),U=i("q-img");return g(),H(L,null,{default:a(()=>[s(t(S),{title:"Brinde | Adicionar"}),e("div",T,[e("div",E,[Q,s(u,{class:"text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16",gutter:"xs"},{default:a(()=>[s(p,{label:"Home",class:"text-grey"}),s(p,{label:"Brindes",class:"text-grey"}),s(p,{label:"Adicionar brinde",class:"text-primary"})]),_:1})])]),e("div",X,[e("div",Z,[G,e("div",J,[s(y,{outlined:"",modelValue:t(o).name,"onUpdate:modelValue":n[0]||(n[0]=l=>t(o).name=l),label:"Nome *","bottom-slots":Boolean(c.errors.name)},{hint:a(()=>[e("div",K,b(c.errors.name),1)]),_:1},8,["modelValue","bottom-slots"])]),e("div",M,[s(D,{options:v.value,"option-value":"id","option-label":"name","emit-value":"","map-options":"",outlined:"",modelValue:t(o).campaign_id,"onUpdate:modelValue":n[1]||(n[1]=l=>t(o).campaign_id=l),label:"Campanha","bottom-slots":Boolean(c.errors.campaign_id),clearable:"","use-chips":"","use-input":"",onFilter:j},{hint:a(()=>[e("div",W,b(c.errors.campaigns),1)]),"selected-item":a(l=>[s(A,{class:"adm-chip-primary q-my-none",label:l.opt.name,dense:""},{default:a(()=>[s(r,{name:"cancel",size:"xs",onClick:me=>l.removeAtIndex(l.index),class:"q-ml-xs cursor-pointer"},null,8,["onClick"])]),_:2},1032,["label"])]),_:1},8,["options","modelValue","bottom-slots"])]),e("div",Y,[s(y,{outlined:"",modelValue:t(o).description,"onUpdate:modelValue":n[2]||(n[2]=l=>t(o).description=l),label:"Descri\xE7\xE3o","bottom-slots":Boolean(c.errors.description),type:"textarea"},{hint:a(()=>[e("div",ee,b(c.errors.description),1)]),_:1},8,["modelValue","bottom-slots"])]),e("div",se,[e("div",oe,[f(" Imagem de capa "),s(r,{name:"help_outline",size:"xs",class:"cursor-pointer"},{default:a(()=>[s(R,{anchor:"center right",self:"center left",offset:[10,10],class:"text-body2 bg-grey-10"},{default:a(()=>[f(" Tamanho recomendado: 800px X 600px ")]),_:1})]),_:1})])]),t(q)?(g(),w("div",te,[s(U,{src:t(q),style:{height:"400px"},class:"app-br-16"},{default:a(()=>[e("div",ae,[s(r,{name:"o_photo",size:"md",class:"q-mr-md"}),s(_,{color:"white",class:"absolute",style:{top:"8px",right:"8px"},flat:"",icon:"close",size:"md",onClick:z}),e("div",V({class:"flex cursor-pointer"},t(m).getRootProps()),[e("input",B(k(t(m).getInputProps())),null,16),f(" Alterar imagem ")],16)])]),_:1},8,["src"])])):(g(),w("div",ne,[e("div",V(t(m).getRootProps(),{class:"column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"}),[e("input",B(k(t(m).getInputProps())),null,16),s(r,{name:"o_photo",size:"md"}),le],16)])),e("div",ie,[s(_,{color:"primary",class:"q-mr-md",rounded:"","no-caps":"",outline:"",onClick:P},{default:a(()=>[s(r,{name:"chevron_left",size:"xs"}),ce]),_:1}),s(_,{color:"primary",rounded:"","no-caps":"",onClick:I,disabled:t(o).processing},{default:a(()=>[s(r,{name:"add",size:"xs"}),re]),_:1},8,["disabled"])])])])]),_:1})}}};export{_e as default};
