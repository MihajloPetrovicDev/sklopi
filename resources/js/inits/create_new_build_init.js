import { createNewBuild } from '../modules/builder_module';

const createNewBuildForm = document.getElementById('create-new-build-form');

createNewBuildForm.addEventListener('submit', function(e) {
    e.preventDefault();

    createNewBuild('build-name', 'buildVisibility');
});