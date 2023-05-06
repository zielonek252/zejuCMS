//small help
//inputboxy
const mdInput=document.querySelector("#md_input");
const titleSeoInput = document.querySelector("#title_seo_input");
//kolory
const przekroczenieTitle=document.querySelector("#przekroczenieTitle");



function sprawdzDlugoscTitle(){
    const dlugoscTitle=document.querySelector("#dlugosc_title");
    dlugoscTitle.innerText=titleSeoInput.value.length;
    if(titleSeoInput.value.length>60){
przekroczenieTitle.style.color="red";
    }else{
        przekroczenieTitle.style.color="green";
    }
}

function sprawdzDlugoscMetaDescription(){
    let metaDesc=document.querySelector("#dlugosc_md");
    metaDesc.innerText=mdInput.value.length;
    if(mdInput.value.length>155){
        przekroczenieMetaDescription.style.color="red";
            }else{
                przekroczenieMetaDescription.style.color="green";
            }
}

titleSeoInput.addEventListener('keyup',sprawdzDlugoscTitle);
mdInput.addEventListener('keyup',sprawdzDlugoscMetaDescription);
window.addEventListener("load",sprawdzDlugoscTitle);
window.addEventListener("load",sprawdzDlugoscMetaDescription);
