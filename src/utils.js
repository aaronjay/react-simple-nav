function getCookie(name) {
	var value = "; " + document.cookie;
	var parts = value.split("; " + name + "=");
	if (parts.length == 2) return parts.pop().split(";").shift();
}

function makeURLParams(urlParams) {
	if (urlParams == null || urlParams == {}) {
		return "";
	}
	return "?" + Object.keys(urlParams).map(key => key + '=' + urlParams[key]).join('&');
}

function QueryStringToJSON(st = "") {       	
	if (st.charAt(0) === '?') {
		st = st.substr(1);
	}
	if (st == "") {
		return null;
	}     
    var pairs = st.split('&');    

    var result = {};
    pairs.forEach(function(pair) {
        pair = pair.split('=');
        result[pair[0]] = decodeURIComponent(pair[1] || '');
    });

    return JSON.parse(JSON.stringify(result));
}

const VabzuButton = (props) => {
 	const text = props.text ? props.text : "";
 	const loading = props.loading ? props.loading : false;
 	const onClick = props.onClick ? props.onClick : null;
		
	return (
		<button style={{width: "220px"}} className={"btn " + (loading ? "btn-info" : "btn-primary")} onClick={onClick}>
			{loading 
				? <span><i className="fa fa-refresh fa-spin"></i></span> 
				: text
			}
		</button>
	)
}
