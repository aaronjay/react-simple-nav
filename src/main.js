function VabzuCMS(props) {
	const [LoginKeyString, setLoginKeyString] = useState("");
	const [ShowScreen, setShowScreen] = useState("Loading");
	const [urlParams, setUrlParams] = useState({});
	const [LoginStatus, setLoginStatus] = useState("Checking Login Status");		
	const [goBack, setGoBack] = useState(false);
			
	const isGoingBack = false;		
				
	useEffect(() => {		
		const query_string = QueryStringToJSON();
		const pn = window.location.pathname;
	
		const urlParams = QueryStringToJSON(window.location.search);	
	
		console.log("pn = " + pn);
		console.log("urlParams = " + urlParams);

		if (pn == '/forgot/') {
			setScreen("Forgot");
		} else if (pn == '/forgot-password/') {
			setScreen("ForgotPassword", urlParams);
		} else {
			axios({
				url: "/api/login-check.php",
			})
			.then(res => {
				if (res.data.LoggedIn === 1) {
					setScreenFromPath(pn);																							
				} else {
					setScreen("Login")
				}
			})
		}

		console.log("Adding Back Button Event Listener");
		
		window.addEventListener('popstate', function(event) {
			console.log("Back Button Pressed");
			console.log(window.history);
			if (event.state) {
				setGoBack(true);
			} else {
				console.log("Going to previous application");
				window.history.back();
			}
		}, false);
	}, []);
	
	useEffect(() => {
		if (goBack) {
			setScreenFromPath(window.location.pathname);
			setGoBack(false);
		}	
	}, [goBack]);
	
	const setScreenFromPath = (pn) => {
		const path = (pn != '/' && pn.substr(-1) == '/' ?
			pn.substr(0, pn.length - 1) : pn);
													
		const routes = Routes(null, urlParams);
		const route = routes.filter(function(route) {
			return route.url == path;
		});			
				
		if (route && route[0]) {
			const st = window.location.search;				
			const urlParams = QueryStringToJSON(st);
			setScreen(route[0].showScreen, urlParams);				
		}
	}

    const setScreen = (nextScreen, urlParams = null) => {
     	console.log("Setting Screen to : " + nextScreen + " urlParams: " + JSON.stringify(urlParams));
     	setUrlParams(urlParams);     	
     	setShowScreen(nextScreen);
    }
     
	const logout = () => {
		axios({
			url: "api/logout.php",
		})
		.then(res => {
			if (res.data.LoggedOut === 1) {
				setScreen("Login")
			} else {			
				alert("Error: " + JSON.stringify(res.data.ErrorMsg));
			}
		})
	}
		     
    useEffect(() => {
    	const urlParamString = makeURLParams(urlParams);
    	
    	const routes = Routes(null, null);
    	
    	const route = routes.filter(function(route) {
    		return route.showScreen == ShowScreen;
    	})[0];
    	
    	if (!goBack && route && route.url) {
    		const pushURL = route.url + (route.url == "/" ? "" : "/") + urlParamString;
    		const routeHistory = {"title": route.title, "url": pushURL};
    		    		    		
    		history.pushState(routeHistory, routeHistory.title, routeHistory.url);
    		
    	}    	    	
    }, [ShowScreen])	
      
    const routes = Routes(setScreen, urlParams);
    	
    const route = routes.filter(function(route) {
    	return route.showScreen == ShowScreen;
    });
    
	if (route && route[0]) {
		return route[0].screen		
	} else {
		return (
			<div className="container">			 
				<div className="row justify-content-center">
					<h1>Unknown Screen... {ShowScreen}</h1>
				</div>
			</div>
		)
	}
}

ReactDOM.render(
	<VabzuCMS />,
	document.getElementById('root')
);