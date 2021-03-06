<?php
//require_once 'mysql.php'; // include this file so we can use the Mysql Class inside this class as well.
	//print 1;
class Questbook
{
    // In this class we'll have a few variables to be used by the class.
    var $mysql; // the mysql variable that will hold the Mysql Object.

    public function __construct()
    {
        $this->mysql = new Mysql(); // Connect to mysql and the database so we can use it.
    }
    // This function does what it says, it gets all of the current news records from the db.
    public function getQuest()
    {
        $rset = $this->mysql->select('*',"co_questbook");
        return $rset;
    }
	public function getQuestLimit()
    {
        $rset = $this->mysql->select('*',"co_questbook","status='1'","idquest DESC","5");
        return $rset;
    }
    public function getQuestById($id)
    {
        $rset = $this->mysql->select('*',"co_questbook","idquest='$id'");
        return $rset;
    }

    // Your going to need some way to add and edit your news entries right?
    // well here ya go :P

    // This function will save you lots of time writing out the fields variable everytime.
    public function buildFields($post, $sep=" ") // $post comes in as an array of variables.
    {
        $fields = ""; // This makes sure we don't run into any past fields.
        foreach($post as $key => $value)
        {
            // foreach will take each element of the $post array and seperate
            // each of the values with its key $post[key] = value;
            $value = mysql_escape_string($value); // We'll do a small security check here.
            // I'll explain that in another tutorial. Basically it protect mysql from hackers.
            if($i == 0)
                $fields .= "$key='$value'";
            else
                $fields .= $sep . "$key='$value'";
            // This will create your fields string based on each element in the post array.
            $i++;
        }
        return $fields; // Return the string, $fields.
    }
    public function addQuest($post)
    {
        $fields = $this->buildFields($post, ", "); // take the post array and break it into a string.
        if( $this->mysql->insert("co_questbook",$fields) ) // This is pretty basic. Inserts the new news record.
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    // This function is just the same as addnews, except that it updates an existing record.
    public function editQuest($post)
    {
        $fields = $this->buildFields($post, ", ");
        $newsId = $post['id']; // retreive the newsId we need to update
        if( $this->mysql->update("co_questbook",$fields,"idquest='$newsId'") )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteQuest($newsId)
    {
        if( $this->mysql->delete("co_questbook","idquest='$newsId'") )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>
