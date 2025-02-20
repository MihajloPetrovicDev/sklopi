import errorService from "./error_service";
import { appUrl } from '../env';


const authService = {
    async generateAndSendResetPasswordLink(email) {
        try {
            const response = await axios.post(appUrl + '/api/generate-and-send-password-reset-link', {
                email: email,
            });
        }
        catch(error) {
            errorService.handleError(error);
        }
    },
}


export default authService;