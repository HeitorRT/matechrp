import{_ as x}from"./Index.5b66d98f.js";import{m,r,o as l,n as h,d as a,a as c,w as b,c as u,s as p,t as v}from"./app.cc606831.js";const _={class:"absolute-full text-subtitle2 flex flex-center transparent"},k={class:"text-white app-fw-700 app-fs-16 app-lh-24 q-mt-md"},g={class:"text-white app-fw-440 app-fs-16 app-lh-24 q-mt-sm"},$={__name:"Item",props:{item:Object},setup(t){const s=m(!1),n=m(!1),d=f=>{n.value=!0};return(f,e)=>{const i=r("q-icon"),w=r("q-img");return l(),h("div",null,[a("div",{class:"student-img-hover-zoom cursor-pointer app-br-16",onMouseover:e[0]||(e[0]=o=>s.value=!0),onMouseleave:e[1]||(e[1]=o=>s.value=!1),onClick:e[2]||(e[2]=o=>d(t.item.name))},[c(w,{src:t.item.image,class:"app-br-16",width:"265px",height:"370px"},{default:b(()=>[a("div",_,[s.value?(l(),u(i,{key:0,name:"lens",size:"44px",color:"white",class:"absolute"})):p("",!0),s.value?(l(),u(i,{key:1,name:"play_arrow",size:"30px",color:"black",class:"absolute"})):p("",!0)])]),_:1},8,["src"])],32),a("div",k,v(t.item.name),1),a("div",g,v(t.item.count_seasons?`${t.item.count_seasons} temporadas`:"Filme"),1),c(x,{content:t.item,show:n.value,onClose:e[3]||(e[3]=o=>n.value=o)},null,8,["content","show"])])}}};export{$ as _};
