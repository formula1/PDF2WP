<?php

class SampleTest extends WP_UnitTestCase {

	function testSample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}
}
    function testSample() {
        //parent::setUp(); // cache flush
        //parent::tearDown(); // rollback
        $ofCourse = true;   //true
        $ofCourseNot = false; //false
        $ofCourseMany = []; //array
        $ofCourseInt = 1; //int
        define('OFCOURSECONST', true); //const
        $ofCourseCONST = OFCOURSECONST; //var const
        $this->assertTrue( $ofCourseCONST );
    }
    function userSample() {

        $user_ids = $this->factory->user->create_many( 25 );
        var_dump($user_ids);
        $user_obj = get_user($user_ids[0]);
}

function test_get_post() {
    //Create new post using method provided by WP
    $org_post_id = $this->factory->post->create();
 
    //get post object using the new post's ID
    $post_obj = get_post( $org_post_id );

    //Get the post ID as given to us by get_post
    $new_post_id = $post_obj->ID;

    //Use pre-defined method to test if the two ID's match
    $this->assertEquals( $org_post_id, $new_post_id );

}
}
