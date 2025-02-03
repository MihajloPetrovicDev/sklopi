import builderModule from "../modules/builder_module.js";


const deleteBuildButton = document.getElementById('delete-build-button');
const buildNameInput = document.getElementById('build-name-input');
const saveBuildNameButton = document.getElementById('save-build-name-button');


builderModule.setupDeleteBuildComponentButtons('build-component-delete-button');


deleteBuildButton.addEventListener('click', function(e) {
    builderModule.deleteBuild(deleteBuildButton.getAttribute('data-encoded-build-id'));
});


saveBuildNameButton.addEventListener('click', function(e) {
    builderModule.saveBuildName(saveBuildNameButton.getAttribute('data-build-id'), buildNameInput.value);
});