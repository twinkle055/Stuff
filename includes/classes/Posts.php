<?php 
    class Posts {
        private $con;
        private $id;
        private $catId;
        private $img;
        private $date;
        private $title;
        private $author;
        private $content;
        private $tags;
        private $status;

        public function __construct($con, $id) {
            $this->con = $con;
            $this->id = $id;
            
            $query = mysqli_query($con, "SELECT * FROM posts WHERE post_id = '$postId'");
            $row = mysqli_fetch_array($query);

            $this->catId = $row['post_cat_id'];
            $this->img = $row['post_img'];
            $this->date = $row['post_date'];
            $this->title = $row['post_title'];
            $this->author = $row['post_author'];
            $this->content = $row['content'];
            $this->tags = $row['tags'];
            $this->status = $row['status'];
        }

        public function getId() {
            return $this->id;
        }

        public function getCatId() {
            return $this->catId;
        }

        public function getImg() {
            return $this->img;
        }

        public function getDate() {
            return $this->date;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getAuthor() {
            return $this->author;
        }

        public function getContent() {
            return $this->content;
        }

        public function getTags() {
            return $this->getTags;
        }

        public function getStatus() {
            return $this->getStatus;
        }
    }
?>