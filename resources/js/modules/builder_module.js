import errorService from '../services/error_service';
import '../app';


export async function createNewBuild(buildNameFieldId, visibilityFieldsName) {
    const buildNameField = document.getElementById(buildNameFieldId);
    const visbilityCheckedRadioButton = document.querySelector(`input[name="${visibilityFieldsName}"]:checked`);
    let buildIsPublic = false;

    if(visbilityCheckedRadioButton.value == 'true') {
        buildIsPublic = true;
    }

    try {
        const response = await axios.post('http://localhost:8000/api/create-new-build', {
            buildName: buildNameField.value,
            buildVisibility: buildIsPublic,
        });

        window.location.href='/builder';
    }
    catch(error) {
        errorService.handleError(error);
    }
}