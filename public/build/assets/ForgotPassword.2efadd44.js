import{G as q}from"./GuestLayout.43ff1355.js";import{h,u as l,c as b,w as t,r as a,o as w,a as s,b as n,H as x,d as e,f as d}from"./app.cc606831.js";import"./_plugin-vue_export-helper.cdc0426e.js";const y={class:"row items-center justify-center"},E=e("div",{class:"col-6 q-pa-none"},[e("div",{class:"student-login-image"})],-1),k={class:"col-6"},V=e("div",{class:"app-fs-42 app-fw-800"}," Esqueci minha senha ",-1),B=e("div",{class:"app-fs-19 app-fw-500"},[d(" Informe seu e-mail. "),e("br"),d(" Reenviaremos um link para redefinir sua senha. ")],-1),C={class:"col-12"},N={class:"col-12"},S=e("div",{class:"flex flex-center"},[e("div",{class:"q-mr-sm"}," Enviar ")],-1),F={class:"q-mr-sm"},I={__name:"ForgotPassword",setup(G){const r=h(),o=l({email:null}),p=()=>{o.post(route("student.auth.forgot-password-send-link"),{preserveState:!0,preserveScroll:!0,onSuccess:()=>{r.notify({type:"positive",message:"Email enviado com sucesso",position:"top"}),l().get(route("student.auth.sign-in"))},onError:()=>{r.notify({type:"negative",message:"Erro ao enviar e-mail. Tente novamente.",position:"top"}),l().get(route("student.auth.forgot"))}})};return(H,c)=>{const u=a("q-img"),i=a("q-card-section"),m=a("q-input"),_=a("q-spinner-ios"),g=a("q-btn"),f=a("q-card");return w(),b(q,null,{default:t(()=>[s(n(x),{title:"Esqueci minha senha"}),e("div",y,[s(u,{src:"/img/student/logo_ligia_academy.png",class:"student-navbar-logo student-logo-login-float"}),E,e("div",k,[s(f,{class:"transparent text-white",flat:"",style:{padding:"0 100px"}},{default:t(()=>[s(i,{class:"q-mb-lg"},{default:t(()=>[V,B]),_:1}),s(i,{class:"row q-col-gutter-sm"},{default:t(()=>[e("div",C,[s(m,{outlined:"",modelValue:n(o).email,"onUpdate:modelValue":c[0]||(c[0]=v=>n(o).email=v),type:"email",label:"E-mail",hint:n(o).errors.email,dark:"",color:"purple"},null,8,["modelValue","hint"])])]),_:1}),s(i,{class:"row q-col-gutter-sm q-mt-sm"},{default:t(()=>[e("div",N,[s(g,{unelevated:"",onClick:p,padding:"10px 24px",class:"app-br-16 app-fs-16 student-bg-purple",disabled:n(o).processing,loading:n(o).processing},{loading:t(()=>[e("div",F,[s(_,{size:"sm"})])]),default:t(()=>[S]),_:1},8,["disabled","loading"])])]),_:1})]),_:1})])])]),_:1})}}};export{I as default};
