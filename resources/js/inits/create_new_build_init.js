import builderModule from "../modules/builder_module.js";


const createNewBuildForm = document.getElementById('create-new-build-form');


createNewBuildForm.addEventListener('submit', function(e) {
    e.preventDefault();

    builderModule.createNewBuild('build-name', 'buildVisibility');
});