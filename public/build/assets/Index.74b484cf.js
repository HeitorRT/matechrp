import{h as ae,u as b,m as T,j as ne,c as u,w as l,r as n,o as m,a as e,b as r,H as ie,d as a,s as p,f as h,q as I,t as C}from"./app.cc606831.js";import{_ as ce}from"./AuthenticatedLayout.0bc0b363.js";import{_ as H}from"./DialogConfirm.f96873bf.js";const re={class:"row q-pb-xl"},de={class:"column col-12 col-md-6 justify-center"},ue=a("div",{class:"app-fs-28 app-fw-700 app-lh-32 text-grey-8"}," Alunos ",-1),me={class:"col-12 col-md-6 flex justify-end items-center"},pe=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Excluir selecionados ",-1),fe=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Novo aluno ",-1),_e={class:"row q-col-gutter-sm"},ye={class:"col-12"},qe={class:"col-12"},be={class:"col-12"},ve={class:"col-12"},xe={class:"col-12"},ge={class:"flex flex-center q-pt-lg q-pa-md q-gutter-sm"},we=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Filtrar ",-1),ke=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20 m-4"}," Limpar ",-1),he=["onClick"],Ve={class:"flex flex-center app-fw-700 app-fs-16"},Ce={class:"app-fw-700 app-fs-16"},Se=a("div",{class:"q-ml-sm"}," Editar ",-1),ze=a("div",{class:"q-ml-sm"}," Visualizar ",-1),Pe=a("div",{class:"q-ml-sm"}," Excluir ",-1),$e=a("div",{class:"q-ml-sm"}," Visualizar ",-1),Ue={class:"row items-center text-grey"},Ee={class:"row items-center text-grey"},Fe={__name:"Index",props:{students:Object,errors:Object,query:Object,canStudentStore:Boolean,canStudentEdit:Boolean,canStudentDestroy:Boolean,canGroupIndex:Boolean},setup(i){const f=i,g=ae(),L=[{name:"name",align:"left",label:"Nome",field:"name",style:"width: 40%"},{name:"email",align:"left",label:"E-mail",field:"email",style:"width: 30%"},{name:"cpf",align:"left",label:"CPF",field:"cpf",style:"width: 20%"},{name:"active",align:"left",label:"Status",field:"active",style:"width: 10%"},{name:"actions",label:"A\xE7\xE3o"}],s=b({orderBy:f.query.orderBy,sort:f.query.sort,page:f.query.page,rowsPerPage:f.query.rowsPerPage,filters:{name:f.query.filters.name,email:f.query.filters.email,cpf:f.query.filters.cpf,phone:f.query.filters.phone}}),R=c=>{s.orderBy===c?s.sort=s.sort=="desc"?"asc":"desc":s.sort=="asc",s.orderBy=c,s.page=1,w()},v=c=>{s.filters[c]=null,w()},w=()=>{s.get(route("admin.student.index"),{preserveState:!0,preserveScroll:!0,onSuccess:()=>S.value=!1})},G=()=>b().get(route("admin.student.create")),Q=c=>b().get(route("admin.student.edit",c)),E=c=>b().get(route("admin.student.show",c)),J=()=>{axios.get(route("admin.student.export",s),{responseType:"blob"}).then(c=>{const o=window.URL.createObjectURL(new Blob([c.data])),x=document.createElement("a");x.href=o,x.setAttribute("download","alunos.xlsx"),x.click()}).catch(c=>{g.notify({type:"negative",message:"Erro ao fazer a exporta\xE7\xE3o",position:"center"})})};function K(c){g.dialog({component:H,componentProps:{title:"Excluir aluno",message:"Tem certeza que deseja excluir esse aluno?"}}).onOk(()=>{b().delete(route("admin.student.destroy",c),{onSuccess:()=>{g.notify({type:"positive",message:"Usu\xE1rio exclu\xEDdo com sucesso",position:"top"})}})})}function M(){g.dialog({component:H,componentProps:{title:"Excluir selecionados",message:"Tem certeza que deseja excluir alunos selecionados?"}}).onOk(()=>{b({ids:k.value.map(c=>c.id)}).post(route("admin.student.destroy-multiples"),{onSuccess:()=>{k.value=[],g.notify({type:"positive",message:"Alunos exclu\xEDdos com sucesso",position:"top"})}})})}const k=T([]),B=ne(()=>Object.values(f.query.filters).filter(c=>c).length),S=T(!1),W=()=>b().get(route("admin.student.index"));return(c,o)=>{const x=n("q-breadcrumbs-el"),X=n("q-breadcrumbs"),d=n("q-icon"),_=n("q-btn"),y=n("q-chip"),j=n("q-space"),Y=n("q-tooltip"),Z=n("q-badge"),V=n("q-input"),A=n("q-select"),F=n("q-menu"),z=n("q-card-section"),P=n("q-separator"),O=n("q-checkbox"),N=n("q-th"),D=n("q-td"),$=n("q-item-section"),U=n("q-item"),ee=n("q-list"),te=n("q-table"),le=n("q-pagination"),oe=n("q-card");return m(),u(ce,null,{default:l(()=>[e(r(ie),{title:"Alunos"}),a("div",re,[a("div",de,[ue,e(X,{class:"text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16",gutter:"xs"},{default:l(()=>[e(x,{label:"Home",class:"text-grey"}),e(x,{label:"Alunos",class:"text-primary"})]),_:1})]),a("div",me,[k.value.length>0&&i.canStudentDestroy?(m(),u(_,{key:0,color:"negative",class:"q-mr-md",rounded:"","no-caps":"",outline:"",onClick:M},{default:l(()=>[e(d,{name:"close",size:"xs"}),pe]),_:1})):p("",!0),i.canStudentStore?(m(),u(_,{key:1,color:"primary",rounded:"","no-caps":"",onClick:G},{default:l(()=>[e(d,{name:"add",size:"xs"}),fe]),_:1})):p("",!0)])]),e(oe,{flat:"",class:"app-br-16"},{default:l(()=>[e(z,{class:"row items-center q-py-sm q-px-lg"},{default:l(()=>[i.query.filters.name?(m(),u(y,{key:0,class:"adm-chip-primary",label:`Nome = ${i.query.filters.name}`},{default:l(()=>[e(d,{name:"cancel",size:"xs",onClick:o[0]||(o[0]=t=>v("name")),class:"q-ml-xs cursor-pointer"})]),_:1},8,["label"])):p("",!0),i.query.filters.email?(m(),u(y,{key:1,class:"adm-chip-primary",label:`E-mail = ${i.query.filters.email}`},{default:l(()=>[e(d,{name:"cancel",size:"xs",onClick:o[1]||(o[1]=t=>v("email")),class:"q-ml-xs cursor-pointer"})]),_:1},8,["label"])):p("",!0),i.query.filters.cpf?(m(),u(y,{key:2,class:"adm-chip-primary",label:`CPF = ${i.query.filters.cpf}`},{default:l(()=>[e(d,{name:"cancel",size:"xs",onClick:o[2]||(o[2]=t=>v("cpf")),class:"q-ml-xs cursor-pointer"})]),_:1},8,["label"])):p("",!0),i.query.filters.phone?(m(),u(y,{key:3,class:"adm-chip-primary",label:`Telefone = ${i.query.filters.phone}`},{default:l(()=>[e(d,{name:"cancel",size:"xs",onClick:o[3]||(o[3]=t=>v("phone")),class:"q-ml-xs cursor-pointer"})]),_:1},8,["label"])):p("",!0),i.query.filters.active==1?(m(),u(y,{key:4,class:"adm-chip-primary",label:"Status = Ativo"},{default:l(()=>[e(d,{name:"cancel",size:"xs",onClick:o[4]||(o[4]=t=>v("active")),class:"q-ml-xs cursor-pointer"})]),_:1})):p("",!0),i.query.filters.active==0?(m(),u(y,{key:5,class:"adm-chip-primary",label:"Status = Inativo"},{default:l(()=>[e(d,{name:"cancel",size:"xs",onClick:o[5]||(o[5]=t=>v("active")),class:"q-ml-xs cursor-pointer"})]),_:1})):p("",!0),e(j),e(_,{round:"",dense:"",flat:"",color:"primary",onClick:J},{default:l(()=>[e(d,{name:"save_alt"}),e(Y,{anchor:"center left",self:"center right",offset:[10,10],class:"text-body2 bg-grey-10"},{default:l(()=>[h(" Exportar todos os registros filtrados ")]),_:1})]),_:1}),e(_,{round:"",dense:"",flat:"",color:"primary"},{default:l(()=>[r(B)?(m(),u(Z,{key:0,color:"primary",floating:"",rounded:"",label:r(B)},null,8,["label"])):p("",!0),e(d,{name:"tune",class:"rotate-90"}),e(F,{style:{"min-width":"500px"},"max-width":"500px",class:"bg-white q-pa-md app-br-16",modelValue:S.value,"onUpdate:modelValue":o[11]||(o[11]=t=>S.value=t)},{default:l(()=>[a("div",_e,[a("div",ye,[e(V,{outlined:"",modelValue:r(s).filters.name,"onUpdate:modelValue":o[6]||(o[6]=t=>r(s).filters.name=t),label:"Nome do aluno"},null,8,["modelValue"])]),a("div",qe,[e(V,{outlined:"",modelValue:r(s).filters.email,"onUpdate:modelValue":o[7]||(o[7]=t=>r(s).filters.email=t),label:"Email"},null,8,["modelValue"])]),a("div",be,[e(V,{outlined:"",modelValue:r(s).filters.cpf,"onUpdate:modelValue":o[8]||(o[8]=t=>r(s).filters.cpf=t),label:"CPF",mask:"###.###.###-##"},null,8,["modelValue"])]),a("div",ve,[e(V,{outlined:"",modelValue:r(s).filters.phone,"onUpdate:modelValue":o[9]||(o[9]=t=>r(s).filters.phone=t),label:"Telefone do aluno",mask:"(##) #########"},null,8,["modelValue"])]),a("div",xe,[e(A,{options:[{label:"Ativo",value:1},{label:"Inativo",value:0}],outlined:"",modelValue:r(s).filters.active,"onUpdate:modelValue":o[10]||(o[10]=t=>r(s).filters.active=t),label:"Status","map-options":"","emit-value":""},{"selected-item":l(t=>[e(y,{tabindex:t.tabindex,"text-color":"white",class:I([{"adm-bg-positive":t.opt.value,"adm-bg-negative":!t.opt.value},"q-my-none"]),dense:""},{default:l(()=>[h(C(t.opt.label),1)]),_:2},1032,["tabindex","class"])]),_:1},8,["modelValue"])])]),a("div",ge,[e(_,{color:"primary",rounded:"","no-caps":"",onClick:w},{default:l(()=>[e(d,{name:"check",size:"xs"}),we]),_:1}),e(_,{color:"primary",rounded:"",outline:"","no-caps":"",onClick:W},{default:l(()=>[e(d,{name:"close",size:"xs"}),ke]),_:1})])]),_:1},8,["modelValue"])]),_:1})]),_:1}),e(z,{class:"q-py-none"},{default:l(()=>[e(P,{color:"grey-3"})]),_:1}),e(z,{class:"q-py-none"},{default:l(()=>[e(te,{rows:i.students.data,columns:L,flat:"",class:"text-grey-8",selected:k.value,"onUpdate:selected":o[12]||(o[12]=t=>k.value=t),selection:"multiple","hide-pagination":"",pagination:{rowsPerPage:r(s).rowsPerPage}},{"header-selection":l(t=>[e(O,{modelValue:t.selected,"onUpdate:modelValue":q=>t.selected=q},null,8,["modelValue","onUpdate:modelValue"])]),"body-selection":l(t=>[e(O,{"model-value":t.selected,"onUpdate:modelValue":(q,se)=>{Object.getOwnPropertyDescriptor(t,"selected").set(q,se)}},null,8,["model-value","onUpdate:modelValue"])]),"header-cell":l(t=>[e(N,{props:t},{default:l(()=>[a("div",{class:"app-fw-700 app-fs-16 cursor-pointer",onClick:q=>R(t.col.name)},[h(C(t.col.label)+" ",1),t.col.name===i.query.orderBy?(m(),u(d,{key:0,name:i.query.sort=="desc"?"keyboard_arrow_up":"keyboard_arrow_down"},null,8,["name"])):p("",!0)],8,he)]),_:2},1032,["props"])]),"header-cell-actions":l(t=>[e(N,{props:t,"auto-width":""},{default:l(()=>[a("div",Ve,C(t.col.label),1)]),_:2},1032,["props"])]),"body-cell-active":l(t=>[e(D,{props:t},{default:l(()=>[e(y,{"text-color":"white",class:I({"adm-bg-positive":t.row.active,"adm-bg-negative":!t.row.active})},{default:l(()=>[h(C(t.row.active?"Ativo":"Inativo"),1)]),_:2},1032,["class"])]),_:2},1032,["props"])]),"body-cell-actions":l(t=>[e(D,{props:t},{default:l(()=>[a("div",Ce,[i.canStudentEdit||i.canStudentDestroy?(m(),u(_,{key:0,icon:"more_vert",flat:""},{default:l(()=>[e(F,{offset:[65,0]},{default:l(()=>[e(ee,null,{default:l(()=>[i.canStudentEdit?(m(),u(U,{key:0,clickable:"",onClick:q=>Q(t.row.id),class:"text-grey-7 flex items-center"},{default:l(()=>[e(d,{name:"edit",size:"xs"}),e($,{"no-wrap":""},{default:l(()=>[Se]),_:1})]),_:2},1032,["onClick"])):p("",!0),e(P),e(U,{clickable:"",onClick:q=>E(t.row.id),class:"text-grey-7 flex items-center"},{default:l(()=>[e(d,{name:"visibility",size:"xs"}),e($,{"no-wrap":""},{default:l(()=>[ze]),_:1})]),_:2},1032,["onClick"]),e(P),i.canStudentDestroy?(m(),u(U,{key:1,clickable:"",onClick:q=>K(t.row.id),class:"text-grey-7 flex flex-center"},{default:l(()=>[e(d,{name:"close",size:"xs"}),e($,{"no-wrap":""},{default:l(()=>[Pe]),_:1})]),_:2},1032,["onClick"])):p("",!0)]),_:2},1024)]),_:2},1024)]),_:2},1024)):(m(),u(_,{key:1,onClick:q=>E(t.row.id),class:"text-grey-7 flex flex-center text-no-wrap",flat:"","no-caps":""},{default:l(()=>[e(d,{name:"visibility",size:"xs"}),$e]),_:2},1032,["onClick"]))])]),_:2},1032,["props"])]),_:1},8,["rows","selected","pagination"]),a("div",Ue,[e(j),a("div",Ee,[h(" Resultado por p\xE1gina "),e(A,{options:[5,10,15],modelValue:r(s).rowsPerPage,"onUpdate:modelValue":[o[13]||(o[13]=t=>r(s).rowsPerPage=t),w],borderless:"",class:"q-ml-md"},null,8,["modelValue"])]),e(le,{modelValue:r(s).page,"onUpdate:modelValue":[o[14]||(o[14]=t=>r(s).page=t),w],max:i.students.meta.last_page,"direction-links":"","boundary-links":"",color:"grey",input:"","icon-first":"keyboard_double_arrow_left","icon-last":"keyboard_double_arrow_right"},null,8,["modelValue","max"])])]),_:1})]),_:1})]),_:1})}}};export{Fe as default};
