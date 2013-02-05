<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 01.02.13
 * Time: 13:26
 * To change this template use File | Settings | File Templates.
 */

class PandoraJsonLDTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../SDSPandora.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider jsonStrDataProvider
	 * @param $jsonInput: encoded string for testing, also expected result
	 */
	public function  testPandoraSDSObjectFromJsonLD( $jsonInput ) {

		//escapes special chars in json
		$serializedInput = json_encode( json_decode( $jsonInput ) );
		//create pandora class object
		$pandoraObject = PandoraJsonLD::pandoraSDSObjectFromJsonLD( $jsonInput );
		print_r($pandoraObject);
		//deserialize into json
		$jsonOutput = PandoraJsonLD::toJsonLD( $pandoraObject );

		$this->assertEquals( $serializedInput, $jsonOutput );
	}

	public function jsonStrDataProvider() {
		return array (
			array( '{}' ),
			array( '{ [] }' ),
			array( '{ "id" : {} }'),
			array( '{ "id" : \'cos ", "ops" : "injection", "id" : "tam\' }' ),
			array( '{ "a" : [ "a", "b" ] }' ),
			array( '{ "id" : "0" }' ),
			array( '{ id : "0" }' ),
			array( 'a' ),
			array( '{ "id" : "0", "property" : { "id" : 1 } }' ),
			array( '{ "property" : [], "property1" : [ "1", "2" ], "property3" : [ { "id" : "2" }, { "id" : "3"} ] }' ),
			array( '{ "id" : "1", "test" : [ { "id_in" : "1" }, { "id_in" : "2" } ] }' )
		);
	}

}