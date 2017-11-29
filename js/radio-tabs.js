function customRadioContainerTabs() {

	jQuery( '.radio-with-container' ).each(
		function (index, element) {
			/* Tab */
			jQuery( element ).find( "> .tab-container .tab-content" ).hide(); // Hide all content

			if (jQuery( element ).find( '> .checkable-element input[type=radio]:checked' ).length) {
				jQuery( element ).find( '> .checkable-element input[type=radio]:checked' ).next().addClass( 'active' );
				var activeTab = jQuery( element ).find( 'input[type=radio]:checked' ).data( "target" );
			} else {
				jQuery( element ).find( "> .checkable-element .tab-label:first-child .checkable-item" ).addClass( "active" ).show(); // Activate first tab
				jQuery( element ).find( "> .checkable-element .tab-label:first-child input:radio" ).attr( "checked", "" );
				var activeTab = jQuery( element ).find( "> .checkable-element .tab-label:first-child input:radio" ).data( "target" );
			}

			jQuery( element ).find( '> .tab-container .' + activeTab ).fadeIn();

			// On Click Event
			jQuery( element ).find( "> .checkable-element .checkable-item" ).click(
				function (e) {
					e.preventDefault();

					jQuery( element ).find( "> .checkable-element .checkable-item" ).removeClass( "active" ); // Remove any "active" class
					jQuery( element ).find( '> .checkable-element .checkable-item input:radio' ).attr( "checked", false )
					jQuery( element ).find( "> .tab-container .tab-content" ).hide(); // Hide all tab content

					jQuery( this ).addClass( "active" );
					jQuery( this ).prev().attr( 'checked', true );

					// //Find the href attribute value to identify the active tab + content
					activeTab = jQuery( this ).prev().data( "target" );
					jQuery( element ).find( '> .tab-container .' + activeTab ).fadeIn(); // Fade in the active ID content

					// return false;
				}
			);
		}
	);
}

function customRadioTabs() {
	jQuery( '.radio-only' ).each(
		function (index, element) {

			if (jQuery( element ).find( 'input[type=radio]:checked' ).length) {
				jQuery( element ).find( 'input[type=radio]:checked' ).next().addClass( 'active' );
			} else {
				jQuery( element ).find( ".checkable-element .tab-label:first-child .checkable-item" ).addClass( "active" ).show(); // Activate first tab
				jQuery( element ).find( ".checkable-element .tab-label:first-child input:radio" ).attr( "checked", "" );
			}

			// On Click Event
			jQuery( element ).find( ".checkable-element .tab-label .checkable-item" ).click(
				function (e) {
					e.preventDefault();
					jQuery( element ).find( ".checkable-item" ).removeClass( "active" ); // Remove any "active" class
					jQuery( element ).find( 'input:radio' ).attr( "checked", false )

					jQuery( this ).addClass( "active" ).prev().attr( 'checked', true );
				}
			);
		}
	);
}

customRadioContainerTabs();
customRadioTabs();
