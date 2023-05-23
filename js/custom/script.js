let projectDiv = document.getElementById("projectsContainer");

let getProjectIconClass = (type) =>{
    switch(type){
        case 'app':
            return 'icon fas fa-mobile-alt';
            break;
        case 'web':
            return 'icon fab fa-chrome';
            break;
        case 'design':
            return 'icon fas fa-image';
            break;
        case 'other':
            return 'icon fas fa-link';
            break;
    }
};

for(project of projects){

    let elem = 
`   
<div class="box-col f-${project['type'].toLowerCase()}">
<div class="box-item">
    <div class="image">
        <a href="#popup-${project['id']}" class="has-popup-media">
            <img src="${project['img']}" alt="project image for ${project['title']}" />
            <span class="info">
                <span class="centrize full-width">
                    <span class="vertical-center">
                        <i class="${getProjectIconClass(project['type'].toLowerCase())}"></i>
                    </span>
                </span>
            </span>
        </a>
    </div>
    <div class="desc">
        <div class="category">${project['type']}</div>
        <a href="#popup-${project['id']}" class="name has-popup-media">${project['title']}</a>
    </div>
    <div id="popup-${project['id']}" class="popup-box mfp-fade mfp-hide">
        <div class="content">
            <div class="image">
                <img src="${project['img']}" alt="project image for ${project['title']}">
            </div>
            <div class="desc">
                <div class="category">${project['type']}</div>
                <h4>${project['title']}</h4>
                <p> ${project['desc']} </p>
                ${
                    project['type'].toLowerCase() == 'web'
                    ?
                    '<a href="#" class="btn"> <span class="animated-button"> <span> View Project </span> </span> <i class="icon fas fa-chevron-right"> </i> </a>'
                    : ''
                }
            </div>
        </div>
    </div>
</div>
</div>
`;
projectDiv.innerHTML += elem;
    
}