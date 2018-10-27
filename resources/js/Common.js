export default class Common{
    constructor(){

    }

    flashFadeOut(element , delay = 3000){
        element.delay(delay).fadeOut();
    }

    flashShow(element){
        element.fadeIn();
    }

    
    ajax(form, url, success, error){
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: form.serialize(),
            success: success,
            headers: {
				'X-Requested-With': 'XMLHttpRequest',
			},
            error: error
        });
    }
    
}