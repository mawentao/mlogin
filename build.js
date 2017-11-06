({
    baseUrl: './template/src',
    dir: './template/dist',
    modules: [
        {   
            name: 'login/page'
        } ,
        {
            name: 'resetpass/page'
        }
    ],  
    fileExclusionRegExp: /^(r|build)\.js$/,
    optimizeCss: 'standard',
    removeCombined: true,

	packages: [
		{name:'frame', location:'frame', main:'main'}
	]
})
