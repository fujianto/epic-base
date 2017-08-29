var div              = document.querySelector( "body" ),		// Elemen will be hooked here
	frag             = document.createDocumentFragment(),
	select           = document.createElement( "select" );	// Element created

select.className     = "body-swapper";
select.id            = "body-swapper";
select.style.cssText = "position:fixed; bottom: 0; left: 0; width: 90px;";
select.options.add( new Option( "box","box", true, true ) );
select.options.add( new Option( "frame","frame" ) );
select.options.add( new Option( "fluid","fluid" ) );

frag.appendChild( select );
div.appendChild( frag );

var select = document.getElementById( 'body-swapper' );
var body   = document.getElementsByTagName( 'body' );

select.addEventListener(
	'change', function(){
		console.log( 'Body: ' + select.value );
		body[0].className = select.value;
	}
)
