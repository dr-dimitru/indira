<?
class Compare_Controller extends Base_Controller {

	public $restful = true;
	
	public function post_index()
	{
            
        $json = stripcslashes(Input::get('data'));
		$json_arr = json_decode($json, true);
		
		$img1 = rawurldecode($json_arr["img1"]);
		$img2 = rawurldecode($json_arr["img2"]);

		return Utilites::compare_pics($img1, $img2);
	}
}