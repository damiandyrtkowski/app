<?php
/**
 * Created by adam
 * Date: 13.03.13
 */


/* class should be used as a tool for rendering forms out of PandoraORM */
class PandoraForms extends WikiaController {

	protected $config;
	protected $data;

	public function __construct() {
	}

	public function setConfig( $config ) {
		$this->config = $config;
	}

	public function getData() {
		return $this->data;
	}

	public function getConfig( $key = null ) {
		if ( $key !== null ) {
			if ( isset( $this->config[ $key ] ) ) {
				return $this->config[ $key ];
			}
		} else {
			return $this->config;
		}
	}

	public function getValue( $key, $config = null ) {
		//add additional logic for checking what should be returned as value
		$config = ( $config !== null ) ? $config : $this->getConfig( $key );

		$result = array();
		if ( isset( $this->data[ $key ] ) ) {
			//set correct
			if ( $config[ 'template' ] === 'reference_list' || $config[ 'template' ] === 'literal_list' ) {
				$result[ 'list' ] = $this->data[ $key ];
			} elseif ( $config[ 'template' ] === 'select' ) {
				$result[ 'selected' ] = $this->data[ $key ];
			} else {
				$result[ 'value' ] = $this->data[ $key ];
			}
		}
		return $result;
	}

	public function getOrmFromRequest( $request, $id ) {
		$config = $this->getConfig();
		$orm = PandoraORM::buildFromType( $request['vcType'], $id );
		foreach ( $config as $formKey => $params ) {
			if ( isset( $request[ $formKey ] ) ) {
				if ( is_array( $request[ $formKey ] ) ) {
					foreach ( $request[ $formKey ] as $value ) {
						$orm->set( $params[ 'ormKey' ], $value );
					}
				} else {
					$orm->set( $params[ 'ormKey' ], $request[ $formKey ] );
				}
			}
		}


		foreach ( $orm->getConfig() as $key => $params ) {
			if ( isset( $requestParams[ $key ] ) ) {
				if ( is_array( $requestParams[ $key ] ) ) {
					foreach ( $requestParams[ $key ] as $values ) {
						$orm->set( $key, $values );
					}
				} else {
					$orm->set( $key, $requestParams[ $key ] );
				}
			}
		}
		return $orm;
	}

	public function load( $data ) {
		if ( $data instanceof PandoraORM ) {
			$this->loadFromORM( $data );
		} else {
			// array with data
			$this->data = $data;
		}
	}

	/**
	 * @param $orm
	 */
	public function loadFromORM( $orm ) {
		foreach ( $this->getConfig() as $params ) {
			$data = $orm->get( $params[ 'ormKey' ] );
			$type = isset( $orm->getConfig()[ $params[ 'ormKey' ] ][ 'childType' ] ) ?
				$orm->getConfig()[ $params[ 'ormKey' ] ][ 'childType' ] : null;
			if ( is_array( $data ) ) {
				//reset data for that key
				$this->data[ $params[ 'ormKey' ] ] = array();
				foreach ( $data as $item ) {
					$value =  $this->extractValue( $item, $type, $params );
					if ( $value !== null ) {
						$this->data[ $params[ 'ormKey' ] ][] = $value;
					}
				}
			} else {
				$value =  $this->extractValue( $data, $type, $params );
				if ( $value !== null ) {
					$this->data[ $params[ 'ormKey' ] ] = $value;
				}
			}
		}
	}

	protected function extractValue( $item, $type, $config ) {
		if( $item instanceof PandoraORM ) {
			//objects or literals
			//dafault name
			$objectKey = ( isset( $config[ 'childKey' ] ) ) ? $config[ 'childKey' ] : 'name';
			$result = array( $objectKey => $item->get( $objectKey ), 'id' => $item->getId() );
			if ( $item->get( 'type' ) === $type ) {
				return $result;
			}
			return null;
		} else {
			return $item;
		}
	}

	public function renderField( $key ) {
		$config = $this->getConfig( $key );

		$config = array_merge( $config, $this->getValue( $config[ 'ormKey' ] ) );
		$config[ 'labelMsg' ] = wfMessage( $config[ 'label' ] )->text();

		//set default controller
		if ( !isset( $config[ 'controller' ] ) ) {
			$config[ 'controller' ] = 'PandoraForms';
		}
		//set default template
		if ( !isset( $config[ 'template' ] ) ) {
			$config[ 'template' ] = 'default';
		}

		$config[ 'name' ] = $key;

		//get translations for options messages
		if ( isset( $config[ 'options' ] ) ) {
			foreach ( $config[ 'options' ] as $key => $options ) {
				$config[ 'options' ][ $key ][ 'text' ] = wfMessage( $options[ 'text' ] )->text();
			}
		}

		$renderedField = F::app()->renderPartial( $config[ 'controller' ], $config[ 'template' ], $config );
		return $renderedField;
	}

	public function referenceItem() {
		$item = $this->getVal('item');
		$pos = $this->getVal('pos');
		$propName = $this->getVal('propName');
		$removeBtnMsg = $this->getVal('removeBtnMsg');

		$this->objectName = htmlspecialchars($item['name']);
		$this->objectId = htmlspecialchars($item['id']);
		$this->objectParam = 'Additional info';
		$this->imgURL = '#';
		$this->removeMsg = $removeBtnMsg;
		$this->pos = $pos;
		$this->propName = $propName;


		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}

}