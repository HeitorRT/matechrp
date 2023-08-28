import{_ as _e}from"./AuthenticatedLayout.0bc0b363.js";import{h as fe,u as Q,j as V,m as C,c as B,w as n,r as _,i as be,o as c,a as l,b as o,H as he,d as a,s as b,t as u,n as f,e as X,f as w,B as S,C as Y,D as M,p as ve,F as ge}from"./app.cc606831.js";import{u as Z}from"./index.common.8f199d34.js";import{_ as ye}from"./DialogConfirm.f96873bf.js";const ke={class:"row q-mb-lg"},xe={class:"column col-12 col-md-6 justify-center"},qe=a("div",{class:"app-fs-28 app-fw-700 app-lh-32 text-grey-8"}," Editar encontro ",-1),Ve={class:"col-12 col-md-6 flex justify-end items-center"},Ce=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Excluir encontro ",-1),we=a("div",{class:"q-ml-sm app-fw-500 app-fs-14 app-lh-20"}," Salvar ",-1),ze={class:"bg-white q-py-lg q-px-lg app-br-16"},De={class:"row q-col-gutter-lg"},Oe=a("div",{class:"col-12 items-center q-mt-xs"},[a("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Informa\xE7\xF5es ")],-1),Ue={class:"col-12 col-md-4"},Be={class:"text-red"},je={class:"col-12 col-md-4"},Se={class:"text-red"},Ye={class:"col-12 col-md-4"},Me={class:"text-red"},Le={class:"col-12 col-md-4"},Te={class:"text-red"},Ee={class:"col-12 col-md-4"},Pe=a("div",null," Para adicionar uma tag, digite o valor e aperte enter. ",-1),Ae={key:0,class:"text-red"},He={class:"col-12 col-md-2"},Ie={class:"text-red"},$e={class:"row items-center justify-end"},Re={class:"col-12 col-md-2"},Ne={class:"text-red"},Fe={class:"row items-center justify-end"},Qe={class:"col-12 col-md-12"},Xe={class:"text-red"},Ze={key:0,class:"col-12 col-md-4"},Ge={class:"text-red"},Je={key:1,class:"col-12 col-md-4"},Ke={class:"text-red"},We={key:2,class:"col-12 col-md-4"},et={class:"text-red"},tt={class:"col-12 items-center q-mt-xs"},ot={class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"},st={key:3,class:"col-12 col-md-12"},lt={class:"absolute-bottom text-subtitle2 row items-center"},at={key:4,class:"col-12"},nt=a("div",{class:"q-mt-sm"}," Clique aqui ou arraste sua imagem ",-1),it=a("div",{class:"col-12 items-center"},[a("div",{class:"q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23"}," Material ")],-1),rt={class:"absolute-bottom text-subtitle2 row items-center"},dt={class:"column"},mt={class:"text-caption"},ct={class:"text-caption"},ut={class:"col-12"},pt={key:0,class:"q-mt-sm"},_t={key:1,class:"q-mt-sm"},ft={class:"col-12"},bt={key:5,class:"col-12 col-md-5"},ht={class:"text-red"},vt={key:6,class:"col-12 col-md-7"},gt={class:"text-red"},yt={key:7,class:"col-12"},kt={class:"text-red"},wt={__name:"Edit",props:{meeting:Object,errors:Object,types:Object,teachers:Array,linkableTypes:Object,contents:Array,seasonsOrChapters:Array,canMeetingDestroy:Boolean},setup(d){const i=d,z=fe(),e=Q({id:i.meeting.id,name:i.meeting.name,description:i.meeting.description,type:i.meeting.type,tags:i.meeting.tags,group_ids:i.meeting.group_ids,student_ids:i.meeting.student_ids,teacher_id:i.meeting.teacher_id,number_of_students:i.meeting.number_of_students,start_at:i.meeting.start_at,end_at:i.meeting.end_at,has_live_offer:i.meeting.has_live_offer,name_offer:i.meeting.name_offer,description_offer:i.meeting.description_offer,embed_offer:i.meeting.embed_offer,materials:i.meeting.materials,image:i.meeting.image,linkable_id:i.meeting.linkable_id,linkable_type:i.meeting.linkable_type,content_id:i.meeting.content_id,has_link_with_content:i.meeting.has_link_with_content}),D=Z({onDrop:(r,s)=>{e.image=r[0],s.length>0&&z.notify({message:"Insira apenas uma imagem",position:"center"})},accept:["image/*"],maxFiles:1}),L=V(()=>e.image?typeof e.image=="object"?URL.createObjectURL(e.image):e.image:""),G=()=>e.image=null,{getRootProps:J,getInputProps:K,isDragActive:W}=Z({onDrop:(r,s)=>{for(var m=0;m<r.length;m++)e.materials.push({id:null,name:r[m].name,size:r[m].size,link:URL.createObjectURL(r[m]),uploadedFile:r[m],is_image:r[m].type.includes("image")})}}),ee=r=>{e.materials=[...e.materials.slice(0,r),...e.materials.slice(r+1)]},te="https://i.pinimg.com/564x/04/54/7c/04547c2b354abb70a85ed8a2d1b33e5f.jpg",oe=()=>{e.transform(r=>({...r,_method:"put"})).post(route("admin.meeting.update",e.id),{onSuccess:r=>{z.notify({type:"positive",message:"Encontro atualizado com sucesso",position:"top"}),e.materials=i.meeting.materials}})},se=()=>{z.dialog({component:ye,componentProps:{title:"Excluir encontro",message:i.meeting.students.length>0?`H\xE1 ${i.meeting.students.length} alunos agendados para o encontro, ao excluir, os agendamentos ser\xE3o exclu\xEDdos. Tem certeza que deseja excluir esse encontro?`:"Tem certeza que deseja excluir esse encontro?"}}).onOk(()=>{Q().delete(route("admin.meeting.destroy",e.id),{onSuccess:()=>{z.notify({type:"positive",message:"Encontro exclu\xEDdo com sucesso",position:"top"})}})})},T=V(()=>e.type=="individual"||e.type=="agendamento"),le=()=>{T.value&&(e.number_of_students=1)},E=C(i.teachers),ae=(r,s,m)=>{s(()=>E.value=i.teachers.filter(g=>g.name.toLowerCase().indexOf(r.toLowerCase())>-1))},ne=V(()=>{let r=new Array;for(const s in i.types)r.push({label:i.types[s],value:s});return r}),P=C(i.contents),ie=(r,s,m)=>{s(()=>P.value=i.contents.filter(g=>g.name.toLowerCase().indexOf(r.toLowerCase())>-1))},re=V(()=>e.linkable_type==="season"?v.value?"Carregando epis\xF3dios":k.value.length===0?"Conte\xFAdo n\xE3o possu\xED temporadas":"Selecione a temporada":e.linkable_type==="chapter"?v.value?"Carregando epis\xF3dios":k.value.length===0?"Conte\xFAdo n\xE3o possu\xED epis\xF3dios":"Selecione o epis\xF3dio":"Selecione"),O=C(i.seasonsOrChapters),k=C(i.seasonsOrChapters),v=C(!1),de=(r,s,m)=>{s(()=>O.value=k.value.filter(g=>g.name.toLowerCase().indexOf(r.toLowerCase())>-1))},A=()=>{if(e.linkable_id=null,O.value=[],k.value=[],v.value=!0,e.linkable_type!=="content"){let r=route("admin.quizz.linkables",{content:e.content_id,type:e.linkable_type});axios.get(r).then(s=>{s.data.items.forEach(m=>{O.value.push({id:m.id,name:m.name}),k.value.push({id:m.id,name:m.name})}),v.value=!1})}else v.value=!1},me=V(()=>{let r=new Array;for(const s in i.linkableTypes)r.push({label:i.linkableTypes[s],value:s});return r}),ce=r=>{const s=document.createElement("a");s.href=r.link,s.setAttribute("download",r.name),s.click()};return(r,s)=>{const m=_("q-breadcrumbs-el"),g=_("q-breadcrumbs"),p=_("q-icon"),y=_("q-btn"),h=_("q-input"),x=_("q-select"),U=_("q-chip"),H=_("q-date"),I=_("q-time"),$=_("q-popup-proxy"),j=_("q-tooltip"),R=_("q-img"),ue=_("q-checkbox"),N=be("close-popup");return c(),B(_e,null,{default:n(()=>[l(o(he),{title:"Encontro | Editar"}),a("div",ke,[a("div",xe,[qe,l(g,{class:"text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16",gutter:"xs"},{default:n(()=>[l(m,{label:"Home",class:"text-grey"}),l(m,{label:"Encontros",class:"text-grey"}),l(m,{label:"Editar encontro",class:"text-primary"})]),_:1})]),a("div",Ve,[d.canMeetingDestroy?(c(),B(y,{key:0,color:"negative",class:"q-mr-md",rounded:"","no-caps":"",outline:"",onClick:se},{default:n(()=>[l(p,{name:"close",size:"xs"}),Ce]),_:1})):b("",!0),l(y,{color:"primary",rounded:"","no-caps":"",onClick:oe,disabled:o(e).processing},{default:n(()=>[l(p,{name:"check",size:"xs"}),we]),_:1},8,["disabled"])])]),a("div",ze,[a("div",De,[Oe,a("div",Ue,[l(h,{outlined:"",modelValue:o(e).name,"onUpdate:modelValue":s[0]||(s[0]=t=>o(e).name=t),label:"Nome do encontro *","bottom-slots":Boolean(d.errors.name)},{hint:n(()=>[a("div",Be,u(d.errors.name),1)]),_:1},8,["modelValue","bottom-slots"])]),a("div",je,[l(x,{options:o(ne),"emit-value":"","map-options":"",outlined:"",modelValue:o(e).type,"onUpdate:modelValue":[s[1]||(s[1]=t=>o(e).type=t),le],label:"Tipo *","bottom-slots":Boolean(d.errors.type)},{hint:n(()=>[a("div",Se,u(d.errors.type),1)]),_:1},8,["options","modelValue","bottom-slots"])]),a("div",Ye,[l(h,{outlined:"",modelValue:o(e).number_of_students,"onUpdate:modelValue":s[2]||(s[2]=t=>o(e).number_of_students=t),modelModifiers:{number:!0},label:"Quantidade de alunos","bottom-slots":Boolean(d.errors.number_of_students),disable:o(T),mask:"########"},{hint:n(()=>[a("div",Me,u(d.errors.number_of_students),1)]),_:1},8,["modelValue","bottom-slots","disable"])]),a("div",Le,[l(x,{options:E.value,"option-value":"id","option-label":"name","emit-value":"","map-options":"",outlined:"",modelValue:o(e).teacher_id,"onUpdate:modelValue":s[3]||(s[3]=t=>o(e).teacher_id=t),label:"Professor *","bottom-slots":Boolean(d.errors.teacher_id),"use-input":"",onFilter:ae},{hint:n(()=>[a("div",Te,u(d.errors.teacher_id),1)]),"selected-item":n(t=>[l(U,{class:"adm-chip-primary q-my-none",label:t.opt.name,dense:""},{default:n(()=>[l(p,{name:"cancel",size:"xs",onClick:q=>t.removeAtIndex(t.index),class:"q-ml-xs cursor-pointer"},null,8,["onClick"])]),_:2},1032,["label"])]),_:1},8,["options","modelValue","bottom-slots"])]),a("div",Ee,[l(x,{label:"Palavras-chave",outlined:"",modelValue:o(e).tags,"onUpdate:modelValue":s[4]||(s[4]=t=>o(e).tags=t),"use-input":"",multiple:"","hide-dropdown-icon":"","input-debounce":"0","new-value-mode":"add-unique","bottom-slots":""},{"selected-item":n(t=>[l(U,{class:"adm-chip-primary q-my-none",label:t.opt,dense:""},{default:n(()=>[l(p,{name:"cancel",size:"xs",onClick:q=>t.removeAtIndex(t.index),class:"q-ml-xs cursor-pointer"},null,8,["onClick"])]),_:2},1032,["label"])]),hint:n(()=>[Pe,d.errors.tags?(c(),f("div",Ae,u(d.errors.tags),1)):b("",!0)]),_:1},8,["modelValue"])]),a("div",He,[l(h,{outlined:"",modelValue:o(e).start_at,"onUpdate:modelValue":s[7]||(s[7]=t=>o(e).start_at=t),mask:"##/##/#### ##:##",label:"Data e hora de inicio *","bottom-slots":Boolean(d.errors.start_at),clearable:""},{prepend:n(()=>[l(p,{name:"o_calendar_today"})]),hint:n(()=>[a("div",Ie,u(d.errors.start_at),1)]),default:n(()=>[l($,{class:"row"},{default:n(()=>[l(H,{modelValue:o(e).start_at,"onUpdate:modelValue":s[5]||(s[5]=t=>o(e).start_at=t),mask:"DD/MM/YYYY HH:mm",flat:"",square:""},null,8,["modelValue"]),l(I,{modelValue:o(e).start_at,"onUpdate:modelValue":s[6]||(s[6]=t=>o(e).start_at=t),mask:"DD/MM/YYYY HH:mm",format24h:"",flat:"",square:""},{default:n(()=>[a("div",$e,[X(l(y,{label:"Ok",color:"primary",flat:""},null,512),[[N]])])]),_:1},8,["modelValue"])]),_:1})]),_:1},8,["modelValue","bottom-slots"])]),a("div",Re,[l(h,{outlined:"",modelValue:o(e).end_at,"onUpdate:modelValue":s[10]||(s[10]=t=>o(e).end_at=t),mask:"##/##/#### ##:##",label:"Data e hora de t\xE9rmino *","bottom-slots":Boolean(d.errors.end_at),clearable:""},{prepend:n(()=>[l(p,{name:"o_calendar_today"})]),hint:n(()=>[a("div",Ne,u(d.errors.end_at),1)]),default:n(()=>[l($,{class:"row"},{default:n(()=>[l(H,{modelValue:o(e).end_at,"onUpdate:modelValue":s[8]||(s[8]=t=>o(e).end_at=t),mask:"DD/MM/YYYY HH:mm",flat:"",square:""},null,8,["modelValue"]),l(I,{modelValue:o(e).end_at,"onUpdate:modelValue":s[9]||(s[9]=t=>o(e).end_at=t),mask:"DD/MM/YYYY HH:mm",format24h:"",flat:"",square:""},{default:n(()=>[a("div",Fe,[X(l(y,{label:"Ok",color:"primary",flat:""},null,512),[[N]])])]),_:1},8,["modelValue"])]),_:1})]),_:1},8,["modelValue","bottom-slots"])]),a("div",Qe,[l(h,{outlined:"",modelValue:o(e).description,"onUpdate:modelValue":s[11]||(s[11]=t=>o(e).description=t),label:"Descri\xE7\xE3o","bottom-slots":Boolean(d.errors.description)},{hint:n(()=>[a("div",Xe,u(d.errors.description),1)]),_:1},8,["modelValue","bottom-slots"])]),o(e).has_link_with_content?(c(),f("div",Ze,[l(x,{options:P.value,"option-value":"id","option-label":"name","emit-value":"","map-options":"",outlined:"",modelValue:o(e).content_id,"onUpdate:modelValue":[s[12]||(s[12]=t=>o(e).content_id=t),A],label:"Vincular ao conte\xFAdo","bottom-slots":Boolean(d.errors.content_id),clearable:"","use-input":"",onFilter:ie},{hint:n(()=>[a("div",Ge,u(d.errors.content_id),1)]),"selected-item":n(t=>[l(U,{class:"adm-chip-primary q-my-none",label:t.opt.name,dense:""},{default:n(()=>[l(p,{name:"cancel",size:"xs",onClick:q=>t.removeAtIndex(t.index),class:"q-ml-xs cursor-pointer"},null,8,["onClick"])]),_:2},1032,["label"])]),_:1},8,["options","modelValue","bottom-slots"])])):b("",!0),o(e).has_link_with_content?(c(),f("div",Je,[o(e).content_id?(c(),B(x,{key:0,options:o(me),"emit-value":"","map-options":"",outlined:"",modelValue:o(e).linkable_type,"onUpdate:modelValue":[s[13]||(s[13]=t=>o(e).linkable_type=t),A],label:"Momento de vincula\xE7\xE3o do evento","bottom-slots":Boolean(d.errors.linkable_type)},{hint:n(()=>[a("div",Ke,u(d.errors.linkable_type),1)]),_:1},8,["options","modelValue","bottom-slots"])):b("",!0)])):b("",!0),o(e).has_link_with_content?(c(),f("div",We,[o(e).linkable_type!=="content"?(c(),B(x,{key:0,options:O.value,"option-value":"id","option-label":"name","emit-value":"","map-options":"",outlined:"",modelValue:o(e).linkable_id,"onUpdate:modelValue":s[14]||(s[14]=t=>o(e).linkable_id=t),label:o(re),"bottom-slots":Boolean(d.errors.linkable_id),onFilter:de,"use-input":"",loading:v.value,disable:v.value||k.value.length===0},{hint:n(()=>[a("div",et,u(d.errors.linkable_id),1)]),"selected-item":n(t=>[l(U,{class:"adm-chip-primary q-my-none",label:t.opt.name,dense:""},{default:n(()=>[l(p,{name:"cancel",size:"xs",onClick:q=>t.removeAtIndex(t.index),class:"q-ml-xs cursor-pointer"},null,8,["onClick"])]),_:2},1032,["label"])]),_:1},8,["options","modelValue","label","bottom-slots","loading","disable"])):b("",!0)])):b("",!0),a("div",tt,[a("div",ot,[w(" Imagem de capa "),l(p,{name:"help_outline",size:"xs",class:"cursor-pointer"},{default:n(()=>[l(j,{anchor:"center right",self:"center left",offset:[10,10],class:"text-body2 bg-grey-10"},{default:n(()=>[w(" Tamanho recomendado: 800px X 600px ")]),_:1})]),_:1})])]),o(L)?(c(),f("div",st,[l(R,{src:o(L),style:{height:"400px"},class:"app-br-16"},{default:n(()=>[a("div",lt,[l(p,{name:"o_photo",size:"md",class:"q-mr-md"}),l(y,{color:"white",class:"absolute",style:{top:"8px",right:"8px"},flat:"",icon:"close",size:"md",onClick:G}),a("div",S({class:"flex cursor-pointer"},o(D).getRootProps()),[a("input",Y(M(o(D).getInputProps())),null,16),w(" Alterar imagem ")],16)])]),_:1},8,["src"])])):(c(),f("div",at,[a("div",S(o(D).getRootProps(),{class:"column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"}),[a("input",Y(M(o(D).getInputProps())),null,16),l(p,{name:"o_photo",size:"md"}),nt],16)])),it,(c(!0),f(ge,null,ve(o(e).materials,(t,q)=>(c(),f("div",{class:"col-12 col-md-3",key:`material-${q}}}`},[l(R,{src:t.is_image?t.link:te,style:{height:"240px"},class:"app-br-16"},{default:n(()=>{var F;return[a("div",rt,[l(p,{name:"attach_file",size:"md",class:"rotate-225 q-mr-md"}),a("div",dt,[a("span",mt,u(t.name.length>25?t.name.slice(0,25)+"...":t.name),1),a("span",ct," ("+u((F=t.size)!=null?F:0)+" kb) ",1)]),l(y,{color:"white",class:"absolute",style:{top:"8px",right:"40px"},flat:"",icon:"file_download",size:"md",onClick:pe=>ce(t),dense:""},{default:n(()=>[l(j,{anchor:"center left",self:"center right",offset:[10,10],class:"text-body2 bg-grey-10"},{default:n(()=>[w(" Clique para fazer o download ")]),_:1})]),_:2},1032,["onClick"]),l(y,{color:"white",class:"absolute",style:{top:"8px",right:"8px"},flat:"",icon:"close",size:"md",onClick:pe=>ee(q),dense:""},{default:n(()=>[l(j,{anchor:"center left",self:"center right",offset:[10,10],class:"text-body2 bg-grey-10"},{default:n(()=>[w(" Remover "+u(t.is_image?"imagem":"arquivo"),1)]),_:2},1024)]),_:2},1032,["onClick"])])]}),_:2},1032,["src"])]))),128)),a("div",ut,[a("div",S(o(J)(),{class:"column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"}),[a("input",Y(M(o(K)())),null,16),l(p,{name:"attach_file",size:"md",class:"rotate-225"}),o(W)?(c(),f("div",pt," Selecionando... ")):(c(),f("div",_t," Clique aqui ou arraste seus arquivos "))],16)]),a("div",ft,[l(ue,{modelValue:o(e).has_live_offer,"onUpdate:modelValue":s[15]||(s[15]=t=>o(e).has_live_offer=t),label:"Oferta ao vivo"},null,8,["modelValue"])]),o(e).has_live_offer?(c(),f("div",bt,[l(h,{outlined:"",modelValue:o(e).name_offer,"onUpdate:modelValue":s[16]||(s[16]=t=>o(e).name_offer=t),label:"Nome da oferta","bottom-slots":Boolean(d.errors.name_offer)},{hint:n(()=>[a("div",ht,u(d.errors.name_offer),1)]),_:1},8,["modelValue","bottom-slots"])])):b("",!0),o(e).has_live_offer?(c(),f("div",vt,[l(h,{outlined:"",modelValue:o(e).embed_offer,"onUpdate:modelValue":s[17]||(s[17]=t=>o(e).embed_offer=t),label:"Link da oferta","bottom-slots":Boolean(d.errors.embed_offer)},{hint:n(()=>[a("div",gt,u(d.errors.embed_offer),1)]),_:1},8,["modelValue","bottom-slots"])])):b("",!0),o(e).has_live_offer?(c(),f("div",yt,[l(h,{outlined:"",modelValue:o(e).description_offer,"onUpdate:modelValue":s[18]||(s[18]=t=>o(e).description_offer=t),label:"Descri\xE7\xE3o da oferta","bottom-slots":Boolean(d.errors.description_offer)},{hint:n(()=>[a("div",kt,u(d.errors.description_offer),1)]),_:1},8,["modelValue","bottom-slots"])])):b("",!0)])])]),_:1})}}};export{wt as default};
