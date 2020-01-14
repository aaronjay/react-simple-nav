function Login(props) {
    const [email, setEmail] = useState("");
    const [pass, setPass] = useState("");
    const [errorMsg, setErrorMsg] = useState("");
        
    const handleChangeEmail = (event) => {
      setEmail(event.target.value)
    }
  
    const handleChangePass = (event) => {
      setPass(event.target.value)
    }
      
    const loginSubmit = (e) => {
        e.preventDefault();
        
        if (email == "") {
        	setErrorMsg("Email is required");
        } else if (pass == "") {
        	setErrorMsg("Password is required");
        } else {
			const postObject = {
				  Email: email,
				  Pass: pass
			 }
		  axios({
			  method: "post",
			  url: "/api/login-action.php",
			  data: postObject
		   })
		  .then(res => {
			  if (res.data.LoggedIn === 1) {
				setErrorMsg("");
				props.setScreen("Home");
			  } else {
				  setErrorMsg(res.data.ErrorMsg);
				}
			})
		 }
	}
                 
  
    return (
        <div className="container" style={{paddingTop: "40px", paddingBottom: "40px"}}>
            <form name="LoginForm">
                <div className="row justify-content-center">
                    <h1>Portal Login</h1>
                </div>
                <div className="row justify-content-center">
                    <div className="col-md-4">Email: (enter anything)<br />
                        <input className="form-control" type="text" name="Email" value={email} onChange={handleChangeEmail} />
                    </div>
                </div>
                <div className="row justify-content-center" style={{paddingTop: "10px"}}>
                    <div className="col-md-4">Password: (password is &quot;react&quot;)<br />
                        <input className="form-control" type="password" name="Password" value={pass} onChange={handleChangePass} />
                    </div>
                </div>
                <div className="row justify-content-center {errorMsg === '' ? 'd-none' : ''}" style={{paddingTop: "10px"}}>
                    <div className="col-md-8 text-center" style={{color: "#ff3333"}}>
                        {errorMsg}
                    </div> 
                </div>
                <div className="row justify-content-center" style={{paddingTop: "10px"}}>
                    <div className="col-md-4 text-center">
                        <button style={{paddingLeft: "40px", paddingRight: "40px"}} className="btn btn-primary" onClick={loginSubmit}>Log In</button>
                    </div>
                </div>
            </form>
        </div>
    );
}
  