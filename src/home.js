function Home(props) {

	const logout = () => {
		axios({
			url: "/api/logout.php",
		})
		.then(res => {
			if (res.data.LoggedOut === 1) {
				this.props.setScreen("Login")
			} else {			
				alert("Error: " + JSON.stringify(res.data.ErrorMsg));
			}
		})
	}

	const pageTwo = () => {
		props.setScreen("Two")
    }
    		
	return (
		<div className="container" style={{paddingTop: "20px", paddingBottom: "50px"}}>			 
			<div className="row justify-content-center">
				<h1>React Simple Navigation</h1>
			</div>
			<div className="row justify-content-center" style={{paddingTop: "20px"}}>
				<p>Logged In Homepage</p>
			</div>

			<div className="row" style={{paddingTop: "50px"}}>
				<div className="col-md-4"><button style={{paddingLeft: "40px", paddingRight: "40px"}} className="btn btn-primary" onClick={pageTwo}>Goto Page 2</button></div>
			</div>
		
			<div className="row" style={{paddingTop: "50px"}}>
				<div className="col-md-4"><button style={{paddingLeft: "40px", paddingRight: "40px"}} className="btn btn-primary" onClick={logout}>Logout</button></div>
			</div>
		 									 
		</div>
	);
}
