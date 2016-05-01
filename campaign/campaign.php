<?php
/* Author: Gayan C. Karunarathna < agchamara93 [at] gmail.com >
 *
 * This class is used to query about campaign details
 */

 require_once __DIR__.'/../db.php';

//used as number of items per page in paging option
define ('ITEMS_PER_PAGE', 5);

 class Campaign {

 	//used to query a single campaign by id
 	//returns an array of campaign data
 	function get_campaign_by_id($id) {
 		$db = new Db();
 		$con = $db->get_connection();

 		$stmt = $con->prepare("SELECT * FROM campaign WHERE id = ?");
 		$stmt->bind_param('i', $id);

 		$result = array();
 		if ($stmt->execute()) {
 			$stmt->bind_result($id, $title, $description, $image, $owner_name, $owner_email, $expire, $sample);

 			while ($stmt->fetch()) {
 				$result['id'] = $id;
 				$result['title'] = $title;
 				$result['description'] = $description;
 				$result['image'] = $image;
 				$result['owner_name'] = $owner_name;
 				$result['owner_email'] = $owner_email;
 				$result['expire'] = $expire;
                $result['sample'] = $sample;
 			}
 			$stmt->free_result();
 			$con->close();
 		}

 		return $result;
 	}

 	//check for campaigns availability
 	// returns true if available, false otherwise
 	function is_campaign_available($id) {
 		$db = new Db();
 		$con = $db->get_connection();

 		$stmt = $con->prepare("SELECT id FROM campaign WHERE id = ?");
 		$stmt->bind_param('i', $id);

 		$stmt->execute();

 		if ($stmt->fetch()) {
 			return true;
 		} else {
 			return false;
 		}
 	}

    //returns list of campaigns with paging option
    function get_campaign_list($page = 1) {
        $db = new Db();
        $con = $db->get_connection();

        $stmt = $con->prepare("SELECT COUNT(id) FROM campaign");
        $stmt->bind_result($count);
        $stmt->execute();

        if ($stmt->fetch()) {

            if ($count + ITEMS_PER_PAGE < ITEMS_PER_PAGE * $page) {
                //invalid page number
                $stmt->free_result();

                return null;
            } else {
                //page ok
                $stmt->free_result();

                $page_offset = ($page -1) * ITEMS_PER_PAGE;
                $stmt = $con->prepare("SELECT * FROM campaign LIMIT ?, ?");
                $items = ITEMS_PER_PAGE;
                $stmt->bind_param("ii", $page_offset, $items);

                $stmt->execute();
                $stmt->bind_result($id, $title, $description, $image, $owner_name, $owner_email, $expire, $sample);

                $result = array();
                while ($stmt->fetch()) {
                    $campaign = array();
                    $campaign['id'] = $id;
     				$campaign['title'] = $title;
     				$campaign['description'] = $description;
     				$campaign['image'] = $image;
     				$campaign['owner_name'] = $owner_name;
     				$campaign['owner_email'] = $owner_email;
     				$campaign['expire'] = $expire;
                    $campaign['sample'] = $sample;

                    $result[] = $campaign;
                }

                $stmt->free_result();
                $con->close();
                return $result;
            }
        } else {
            return null;
        }
    }

    function get_latest_campaigns() {
        $db = new Db();
        $con = $db->get_connection();

        $stmt = $con->prepare("select * from campaign where expire > curdate() order by rand() limit 3");
        $stmt->execute();

        $stmt->bind_result($id, $title, $description, $image, $owner_name, $owner_email, $expire, $sample);

        $result = array();
        while ($stmt->fetch()) {
            $campaign = array();
            $campaign['id'] = $id;
            $campaign['title'] = $title;
            $campaign['description'] = $description;
            $campaign['image'] = $image;
            $campaign['owner_name'] = $owner_name;
            $campaign['owner_email'] = $owner_email;
            $campaign['expire'] = $expire;
            $campaign['sample'] = $sample;

            $result[] = $campaign;
        }
        $stmt->free_result();
        $con->close();
        return $result;
    }

    function get_campaign_url($id) {
        return "http://domain.com/campaign/?id=".$id;
    }
 }

// // ## Test
//   $c = new Campaign();
// // ## $c->get_campaign_by_id(2);
// //
// // print_r($c->is_campaign_available('2'));
// print_r($c->get_campaign_list())
?>
