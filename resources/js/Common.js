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

    getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    getParameters() {
        let urlParams;
        let match,
            pl = /\+/g,  // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
            query = window.location.search.substring(1);

        urlParams = {};
        while (match = search.exec(query))
            urlParams[decode(match[1])] = decode(match[2]);
        return urlParams;
    }

    addParams(params, url){
        for (let param in params) {
            if(param == 'page') continue;
            if(!url.match(/\?/)){
                url += `?${param}=` + params[param];
            }else{
                url += `&${param}=` + params[param];
            }
        }
        return url;
    }
    
}