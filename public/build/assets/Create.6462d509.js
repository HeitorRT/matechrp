import{_ as I}from"./AuthenticatedLayout.0bc0b363.js";import{h as A,u as N,j as R,c as U,w as l,r as i,o as p,a as o,b as s,H as D,d as e,t as u,f as _,n as x,B as v,C as y,D as w}from"./app.cc606831.js";import{u as S}from"./index.common.8f199d34.js";const $={class:"row q-mb-lg"},H={class:"column col-12 col-md-6 justify-center"},O=e("div",{class:"app-fs-28 app-fw-700 app-lh-32 text-grey-8"}," Adicionar temporada ",-1),T={class:"bg-white q-py-lg q-px-lg app-br-16"},F={class:"row q-col-gutter-lg"},L=e("div",{class:"col-12 items-center q-mt-xs"},[e("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Informa\xE7\xF5es ")],-1),Q={class:"col-12 col-md-3"},E={class:"text-red"},X={class:"col-12 col-md-6"},Z={class:"text-red"},G={class:"col-12 col-md-3"},J={class:"text-red"},K={class:"col-12 items-center q-mt-xs"},M={class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"},W={key:0,class:"col-12"},Y={class:"absolute-bottom text-subtitle2 row items-center"},ee={key:1,class:"col-12"},oe=e("div",{class:"q-mt-sm"}," Clique aqui ou arraste sua imagem ",-1),te={class:"col-12 flex justify-end items-center"},se=e("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Salvar ",-1),ce={__name:"Create",props:{content:Object,errors:Object,numbers:Array},setup(n){const V=n,b=A(),t=N({id:null,name:null,number_of_chapters:null,number:null,image:null}),r=S({onDrop:(f,c)=>{c.length>0?b.notify({message:"Insira apenas uma imagem",position:"center"}):t.image=f[0]},accept:["image/*"],maxFiles:1}),g=R(()=>t.image==null?"":typeof t.image=="object"?URL.createObjectURL(t.image):t.image),k=()=>t.image=null,C=()=>{t.post(route("admin.content.season.store",{content:V.content.id}),{onSuccess:()=>{b.notify({type:"positive",message:`Temporada ${t.name} cadastrada com sucesso`,position:"top"})}})};return(f,c)=>{const m=i("q-breadcrumbs-el"),B=i("q-breadcrumbs"),h=i("q-select"),j=i("q-input"),z=i("q-tooltip"),d=i("q-icon"),q=i("q-btn"),P=i("q-img");return p(),U(I,null,{default:l(()=>[o(s(D),{title:n.content.name},null,8,["title"]),e("div",$,[e("div",H,[O,o(B,{class:"text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16",gutter:"xs"},{default:l(()=>[o(m,{label:"Home",class:"text-grey"}),o(m,{label:"Conte\xFAdos",class:"text-grey"}),o(m,{label:n.content.name,class:"text-grey"},null,8,["label"]),o(m,{label:"Adicionar temporada",class:"text-primary"})]),_:1})])]),e("div",T,[e("div",F,[L,e("div",Q,[o(h,{"option-value":"position",options:n.numbers,"option-disable":a=>!a.empty,"option-label":a=>a.empty?a.position:`${a.position} (desabilitado)`,"emit-value":"","map-options":"",outlined:"",modelValue:s(t).number,"onUpdate:modelValue":c[0]||(c[0]=a=>s(t).number=a),label:"N\xFAmero da temporada *","bottom-slots":Boolean(n.errors.number)},{hint:l(()=>[e("div",E,u(n.errors.number),1)]),_:1},8,["options","option-disable","option-label","modelValue","bottom-slots"])]),e("div",X,[o(j,{outlined:"",modelValue:s(t).name,"onUpdate:modelValue":c[1]||(c[1]=a=>s(t).name=a),label:"Nome *","bottom-slots":Boolean(n.errors.name)},{hint:l(()=>[e("div",Z,u(n.errors.name),1)]),_:1},8,["modelValue","bottom-slots"])]),e("div",G,[o(h,{options:[...Array(50).keys()].map(a=>++a),outlined:"",modelValue:s(t).number_of_chapters,"onUpdate:modelValue":c[2]||(c[2]=a=>s(t).number_of_chapters=a),label:"Quantidade de epis\xF3dios *","bottom-slots":Boolean(n.errors.number_of_chapters)},{hint:l(()=>[e("div",J,u(n.errors.number_of_chapters),1)]),_:1},8,["options","modelValue","bottom-slots"])]),e("div",K,[e("div",M,[_(" Capa principal "),o(d,{name:"help_outline",size:"xs",class:"cursor-pointer"},{default:l(()=>[o(z,{anchor:"center right",self:"center left",offset:[10,10],class:"text-body2 bg-grey-10"},{default:l(()=>[_(" Tamanho recomendado: 800px X 600px ")]),_:1})]),_:1})])]),s(g)?(p(),x("div",W,[o(P,{src:s(g),class:"app-br-16"},{default:l(()=>[e("div",Y,[o(d,{name:"o_photo",size:"md",class:"q-mr-md"}),o(q,{color:"white",class:"absolute",style:{top:"8px",right:"8px"},flat:"",icon:"close",size:"md",onClick:k}),e("div",v({class:"flex cursor-pointer"},s(r).getRootProps()),[e("input",y(w(s(r).getInputProps())),null,16),_(" Alterar imagem ")],16)])]),_:1},8,["src"])])):(p(),x("div",ee,[e("div",v(s(r).getRootProps(),{class:"column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"}),[e("input",y(w(s(r).getInputProps())),null,16),o(d,{name:"o_photo",size:"md"}),oe],16)])),e("div",te,[o(q,{color:"primary",rounded:"","no-caps":"",onClick:C,disabled:s(t).processing},{default:l(()=>[o(d,{name:"check",size:"xs"}),se]),_:1},8,["disabled"])])])])]),_:1})}}};export{ce as default};
