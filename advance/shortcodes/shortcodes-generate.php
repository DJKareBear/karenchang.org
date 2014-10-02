<?php
	function apollo13_shortcodes(){
		global $content_width;
        $shortcodes = array(
			array(
				'id' => 'typography',
				'name' => __be( 'Typography' ),
				'codes' => array(
                    array(
                        'name' => __be( 'Dropcap' ),
                        'code' => 'dropcap',
                        'fields' => array(
//                            array(
//                                'name' => __be( 'Background' ),
//                                'id' => 'bg',
//                                'default' => 'default',
//                                'place' => 'attr',
//                                'type' => 'select',
//                                'options' => array(
//                                    'default' => 'default',
//                                    'black' => 'black',
//                                    'blue' => 'blue',
//                                    'green' => 'green'
//                                )
//                            ),
                            array(
                                'name' => __be( 'Text' ),
                                'id' => 'text',
                                'default' => '',
                                'place' => 'content',
                                'type' => 'input'
                            )
                        )
                    ),
                    array(
                        'name' => __be( 'Image with lightbox' ),
                        'code' => 'image',
                        'fields' => array(
                            array(
                                'name' => __be( 'Align' ),
                                'id' => 'align',
                                'default' => 'none',
                                'place' => 'attr',
                                'type' => 'select',
                                'options' => array(
                                    'none' => 'none',
                                    'center' => 'center',
                                    'left' => 'left',
                                    'right' => 'right',
                                )
                            ),
                            array(
                                'name' => __be( 'Image' ),
                                'id' => 'img',
                                'default' => '',
                                'place' => 'attr',
                                'type' => 'upload'
                                //----------------HERE
                            ),
                            array(
                                'name' => __be( 'url' ),
                                'id' => 'url',
                                'default' => '',
                                'place' => 'attr',
                                'type' => 'upload'
                            ),
                            array(
                                'name' => __be( 'Link dimensions' ),
                                'id' => 'dimensions',
                                'default' => '',
                                'place' => 'attr',
                                'type' => 'input'
                            ),
                            array(
                                'name' => __be( 'Title' ),
                                'id' => 'alt',
                                'default' => '',
                                'place' => 'attr',
                                'type' => 'input'
                            ),
//                            array(
//                                'name' => __be( 'Border' ),
//                                'id' => 'border',
//                                'default' => 'on',
//                                'place' => 'attr',
//                                'type' => 'radio',
//                                'options' => array(
//                                    'on' => __be( 'Yes' ),
//                                    'off' => __be( 'No' )
//                                ),
//                            ),
                        )
                    ),
                    array(
                        'name' => __be( 'Highlight' ),
                        'code' => 'highlight',
                        'fields' => array(
                            array(
                                'name' => __be( 'Background' ),
                                'id' => 'bg',
                                'default' => 'yellow',
                                'place' => 'attr',
                                'type' => 'select',
                                'options' => array(
                                    'yellow' => 'yellow',
                                    'black' => 'black',
                                    'white' => 'white',
                                    'grey' => 'grey'
                                )
                            ),
                            array(
                                'name' => __be( 'Text' ),
                                'id' => 'text',
                                'default' => '',
                                'place' => 'content',
                                'type' => 'input'
                            )
                        )
                    ),
                    array(
                        'name' => __be( 'Button' ),
                        'code' => 'button',
                        'fields' => array(
                            array(
                                'name' => __be( 'Class' ),
                                'id' => 'class',
                                'default' => 'default',
                                'place' => 'attr',
                                'type' => 'select',
                                'options' => array(
                                    'default' => 'default',
                                    'blue' => 'blue',
                                    'grey' => 'grey',
                                    'red' => 'red',
                                    'green' => 'green',
                                    'orange' => 'orange',
                                )
                            ),
                            array(
                                'name' => __be( 'url' ),
                                'id' => 'url',
                                'default' => '/',
                                'place' => 'attr',
                                'type' => 'upload'
                            ),
                            array(
                                'name' => __be( 'Color' ),
                                'id' => 'color',
                                'default' => '',
                                'place' => 'attr',
                                'type' => 'color'
                            ),
                            array(
                                'name' => __be( 'Background color' ),
                                'id' => 'bgcolor',
                                'default' => '',
                                'place' => 'attr',
                                'type' => 'color'
                            ),
                            array(
                                'name' => __be( 'Text on button' ),
                                'id' => 'text',
                                'default' => 'Press',
                                'place' => 'content',
                                'type' => 'input'
                            ),
                            array(
                                'name' => __be( 'Title' ),
                                'id' => 'title',
                                'default' => '',
                                'place' => 'attr',
                                'type' => 'input'
                            ),
                        )
                    )
				)
			),
			array(
				'id' => 'toggles',
				'name' => __be( 'Tabs' ),
				'codes' => array(
					array(
						'name' => __be( 'Tabs' ),
						'code' => 'tabs',
						'fields' => array( 
							array(
								'name' => __be( 'Title' ),
								'subtag' => 'tab',
								'id' => 'title',
								'default' => '',
								'place' => 'attr',
								'type' => 'input',
								'additive' => true
							),
							array(
								'name' => __be( 'Content' ),
								'subtag' => 'tab',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => true
							),
							array(
								'name' => __be( 'Add more fields' ),
								'id' => 'additive',
								'place' => 'additive',
								'type' => 'additive',
							)
						)
					),
				)
			),
			array(
				'id' => 'columns',
				'name' => __be( 'Columns' ),
				'codes' => array(
					array(
						'name' => __be( 'Column 50%' ),
						'code' => 'nocodecols50',
						'fields' => array( 
							array(
								'name' => __be( 'Left 50%' ),
								'subtag' => 'left50',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Right 50%' ),
								'subtag' => 'right50',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Add clear' ),
								'id' => 'addclear',
								'subtag' => 'clear',
								'default' => 'on',
								'place' => 'addclear',
								'type' => 'radio',
								'options' => array(
									'on' => 'Yes',
									'off' => 'No'
								),
								'additive' => false,
							)
						)
					),
					array(
						'name' => __be( 'Column 33%' ),
						'code' => 'nocodecols33',
						'fields' => array( 
							array(
								'name' => __be( 'Left 33%' ),
								'subtag' => 'left33',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Center 33%' ),
								'subtag' => 'center33',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Right 33%' ),
								'subtag' => 'right33',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Add clear' ),
								'id' => 'addclear',
								'subtag' => 'clear',
								'default' => 'on',
								'place' => 'addclear',
								'type' => 'radio',
								'options' => array(
									'on' => 'Yes',
									'off' => 'No'
								),
								'additive' => false,
							)
						)
					),
					array(
						'name' => __be( 'Column 25%' ),
						'code' => 'nocodecols25',
						'fields' => array( 
							array(
								'name' => __be( 'Left 25%' ),
								'subtag' => 'left25',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Center 25%' ),
								'subtag' => 'center25-1',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Center 25%' ),
								'subtag' => 'center25-2',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Right 25%' ),
								'subtag' => 'right25',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Add clear' ),
								'id' => 'addclear',
								'subtag' => 'clear',
								'default' => 'on',
								'place' => 'addclear',
								'type' => 'radio',
								'options' => array(
									'on' => 'Yes',
									'off' => 'No'
								),
								'additive' => false,
							)
						)
					),
					array(
						'name' => __be( 'Column 20%' ),
						'code' => 'nocodecols20',
						'fields' => array( 
							array(
								'name' => __be( 'Left 20%' ),
								'subtag' => 'left20',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Center 20%' ),
								'subtag' => 'center20-1',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Center 20%' ),
								'subtag' => 'center20-2',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Center 20%' ),
								'subtag' => 'center20-3',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Right 20%' ),
								'subtag' => 'right20',
								'id' => 'content',
								'default' => '',
								'place' => 'content',
								'type' => 'textarea',
								'additive' => false
							),
							array(
								'name' => __be( 'Add clear' ),
								'id' => 'addclear',
								'subtag' => 'clear',
								'default' => 'on',
								'place' => 'addclear',
								'type' => 'radio',
								'options' => array(
									'on' => 'Yes',
									'off' => 'No'
								),
								'additive' => false,
							)
						)
					),
					array(
						'name' => __be( 'Line' ),
						'code' => 'line',
						'fields' => array() 
					),
					array(
						'name' => __be( 'Clear' ),
						'code' => 'clear',
						'fields' => array() 
					),
				)
			),
//			array(
//				'id' => 'video',
//				'name' => __be( 'Video' ),
//				'codes' => array(
//					array(
//						'name' => __be( 'Video' ),
//						'code' => 'video',
//						'fields' => array(
//							array(
//								'name' => __be( 'Type' ),
//								'id' => 'type',
//								'default' => 'youtube',
//								'place' => 'attr',
//								'type' => 'select',
//								'options' => array(
//									'youtube' => 'youtube',
//									'vimeo' => 'vimeo'
//								)
//							),
//							array(
//								'name' => __be( 'Movie id, or movie link' ),
//								'place' => 'attr',
//								'id' => 'src',
//								'default' => '',
//								'type' => 'input',
//							),
//							array(
//								'name' => __be( 'Height' ),
//								'place' => 'attr',
//								'id' => 'height',
//								'default' => '315',
//								'type' => 'input',
//							),
//							array(
//								'name' => __be( 'Width' ),
//								'place' => 'attr',
//								'id' => 'width',
//								'default' => '560',
//								'type' => 'input',
//							),
//							array(
//								'name' => __be( 'Autoplay' ),
//								'id' => 'autoplay',
//								'default' => 'off',
//								'place' => 'attr',
//								'type' => 'radio',
//								'options' => array(
//									'on' => 'On',
//									'off' => 'Off'
//								)
//							),
//						)
//					),
//				)
//			),
            array(
                'id' => 'embed',
                'name' => __be( 'Embeds(Video, Twitter status, etc.)' ),
                'codes' => array(
                    array(
                        'name' => __be( 'Embed' ),
                        'code' => 'embed',
                        'fields' => array(
                            array(
                                'name' => __be( 'Link of embed' ),
                                'place' => 'content',
                                'id' => 'src',
                                'default' => '',
                                'type' => 'input',
                            ),
                            array(
                                'name' => __be( 'Height' ),
                                'place' => 'attr',
                                'id' => 'height',
                                'default' => round(0.5625 * $content_width), //9:16 = 0.5625
                                'type' => 'input',
                            ),
                            array(
                                'name' => __be( 'Width' ),
                                'place' => 'attr',
                                'id' => 'width',
                                'default' => $content_width,
                                'type' => 'input',
                            ),
                        )
                    ),
                )
            ),
		);
		
		return $shortcodes;
	}
	
	function apollo13_shortcodes_make_field( $field, $code ){
		$html = '';
		//we produce uniq id
		$id = 'apollo13-' . $code . '-' . $field['id'];
		$class = $field['place'];
		
		if( isset( $field['subtag'] ) && ( $field['subtag'] != '' ) ){
			$id .= '-' . $field['subtag'];//we add info for js engine
		}
		
		if( isset( $field['additive'] ) && $field['additive'] ){
			$id .= '-1';//we add info for js engine
			$class .= ' additive';
			
		}
		
		
		//checking what type o field to make
		if ( $field['type'] == 'upload' ) {
			$html .= '<div class="upload-input ' . $class . '">';
//				<p class="desc">$field['desc']; </p>
			$html .= '<label><span class="label-name">' . $field['name'] . '</span>';
			$html .= '<input id="' . $id . '" class="' . $class . '" type="text" size="36" name="' . $id . '" value="' . $field['default'] .'" />';
			$html .= '</label>';
			$html .= '<input id="upload_' . $id . '" class="upload-image-button ' . $class . '" type="button" value="' . __be( 'Upload/Select Image' ) . '" />';
			$html .= '</div>';
		}
		
		elseif ( $field['type'] == 'input' ) {
			$html .= '<div class="text-input ' . $class . '">';
//				<p class="desc">$field['desc']; </p>
			$html .= '<label><span class="label-name">' . $field['name'] . '</span>';
			$html .= '<input id="' . $id . '" class="' . $class . '" type="text" size="36" name="' . $id . '" value="' . $field['default'] .'" />';
			$html .= '</label>';
			$html .= '</div>';
		}
		
		elseif ( $field['type'] == 'select' ) {
			$selected = $field['default'];
			$html .= '<div class="select-input ' . $class . '">';
//				<p class="desc">$field['desc']; </p>
			$html .= '<label><span class="label-name">' . $field['name'] . '</span>';
			$html .= '<select id="' . $id . '" class="' . $class . '" name="' . $id . '">';
			
			foreach( $field['options'] as $html_value => $html_option ) { 
				$selected_attr = '';
				if ( $html_value == $selected ){
					$selected_attr = ' selected="selected"';
				}
				$html .= '<option value="' . $html_value . '"' . $selected_attr . '>' . $html_option . '</option>';
			}
			
			$html .= '</select>';
			$html .= '</label>';
			$html .= '</div>';
		}
		
		elseif ( $field['type'] == 'radio' ) {
			$selected = $field['default'];
			$html .= '<div class="radio-input ' . $class . '">';
//				<p class="desc">$field['desc']; </p>
			$html .= '<span class="label-like">' . $field['name'] . '</span>';
			
			foreach( $field['options'] as $html_value => $html_option ) { 
				$selected_attr = '';
				if ( $html_value == $selected ){
					$selected_attr = ' checked="checked"';
				}
				$html .= '<label><input type="radio" name="' . $id . '" class="' . $class . '" value="' . $html_value . '"' . $selected_attr . ' />' . $html_option . '</label>';
			}
											
			$html .= '</div>';
		}
		
		elseif ( $field['type'] == 'color' ) {
			$html .= '<div class="color-input ' . $class . '">';
//				<p class="desc">$field['desc']; </p>
			$html .= '<label><span class="label-name">' . $field['name'] . '</span>';
			$html .= '<input id="' . $id . '" type="text" class="with-color ' . $class .'" name="' . $id . '" value="' . $field['default'] . '" />';
			$html .= '</label>';
			$html .= '</div>';
		}
		
		elseif ( $field['type'] == 'textarea' ) {
			$html .= '<div class="textarea-input ' . $class . '">';
//				<p class="desc">$field['desc']; </p>
			$html .= '<label><span class="label-name">' . $field['name'] . '</span>';
			$html .= '<textarea id="' . $id . '" class="' . $class . '" name="' . $id . '">' . $field['default'] . '</textarea>';
			$html .= '</label>';
			$html .= '</div>';
		}
		
		elseif ( $field['type'] == 'additive' ) {
			$html .= '<div class="add-more-parent"><span class="button add-more-fields"><span>+</span>' . $field['name'] . '</span></div>';
		}
		
		return $html;
	}