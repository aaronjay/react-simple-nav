const Routes = (setScreen, urlParams) => {

	return (
		[
			{
				showScreen: "Login",
				title: "Portal Login",
				url: "/login",
				screen: <Login setScreen={setScreen} />
			},
			{
				showScreen: "Home",
				title: "Portal Home",
				url: "/",
				screen: <Home setScreen={setScreen} />
			},
			{
				showScreen: "One",
				title: "Page One",
				url: "/one",
				screen: <One setScreen={setScreen} params={urlParams} />
			},
			{
				showScreen: "Loading",
				title: "Loading",
				url: null,
				screen: <Loading />
			}
		]
	)
}
