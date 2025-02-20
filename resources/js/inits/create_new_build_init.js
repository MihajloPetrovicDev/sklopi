import builderModule from "../modules/builder_module";


const createNewBuildForm = document.getElementById('create-new-build-form');


createNewBuildForm.addEventListener('submit', function(e) {
    e.preventDefault();

    builderModule.createNewBuild('build-name', 'buildVisibility');
});