let projectDiv = document.getElementById("projectsContainer");

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
                        <i class="icon fas fa-mobile-alt"></i>
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
            </div>
        </div>
    </div>
</div>
</div>
`;
projectDiv.innerHTML += elem;
    
}