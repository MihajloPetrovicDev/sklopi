import { setupDeleteBuildComponentButtons, deleteBuild, saveBuildName } from "../modules/builder_module";


const deleteBuildButton = document.getElementById('delete-build-button');
const buildNameInput = document.getElementById('build-name-input');
const saveBuildNameButton = document.getElementById('save-build-name-button');


setupDeleteBuildComponentButtons('build-component-delete-button');


deleteBuildButton.addEventListener('click', function(e) {
    deleteBuild(deleteBuildButton.getAttribute('data-encoded-build-id'));
});


saveBuildNameButton.addEventListener('click', function(e) {
    saveBuildName(saveBuildNameButton.getAttribute('data-build-id'), buildNameInput.value);
});