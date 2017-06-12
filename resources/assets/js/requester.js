var app = app || {};

app.requester = (function () {
    function Requester() {
    }

    Requester.prototype.get = function (url, headers) {
        return makeRequest('GET', headers, url);
    };

    Requester.prototype.post = function (url, headers, data) {
        return makeRequest('POST', headers, url, data);
    };

    Requester.prototype.delete = function (url, headers, data) {
        if(typeof data == 'string'){
            data+='&_method=DELETE';
        }else{
            data['_method'] = 'DELETE';
        }
        return makeRequest('POST', headers, url, data);
    };

    Requester.prototype.put = function (url, headers, data) {
        if(typeof data == 'string'){
            data+='&_method=PUT';
        }else{
            data['_method'] = 'PUT';
        }
        return makeRequest('POST', headers, url, data);
    };

    function makeRequest(method, headers, url, data) {
        if (data == undefined) {
            data = {};
        }

        if (headers == undefined) {
            headers = {};
        }

        headers['X-CSRF-TOKEN'] = $('input[name="csrf_token"]').val();

        var deffer = Q.defer();

        $.ajax({
            method: method,
            headers: headers,
            url: url,
            dataType: 'json',
            data: data,
            success: function (data) {
                deffer.resolve(data);
            },
            error: function (error) {
                deffer.reject(error);
            }
        }, "json");

        return deffer.promise;
    }

    return {
        load: function () {
            return new Requester();
        }
    }
}());

var requester = app.requester.load();