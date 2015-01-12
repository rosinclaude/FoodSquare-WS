<?php

namespace Foodsquare\CommonBundle\Command;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Foodsquare\CommonBundle\Entity\Restaurant;
use Foodsquare\CommonBundle\Entity\Photo;
use Foodsquare\CommonBundle\Utils\acurl;

/**
 * Description of ImportRestaurantCommand
 *
 * @author ikounga_marvel
 */
class ImportRestaurantCommand extends ContainerAwareCommand{
    
    
    private $url_image = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=700&photoreference=X_PHOTOREF_X&key=AIzaSyDnPwB1DFZmyLxMycXFuENozNzt1TBoONE";
    
    private $em;
    private $rest_rep;


    protected function configure()
    {
        $this
            ->setName('restaurant:import')
            ->setDescription('Importer la liste des restaurants')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->rest_rep = $this->em->getRepository('FoodsquareCommonBundle:Restaurant');
        
            
        
                
        $page = 1;
        $next_page_token = "";
        
        do{
            $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=48.3,4.0833&radius=200000&types=restaurant&key=AIzaSyDnPwB1DFZmyLxMycXFuENozNzt1TBoONE&language=fr&pagetoken=".$next_page_token;
            //$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=48.2973451,4.0744009&radius=200000&types=restaurant&key=AIzaSyDnPwB1DFZmyLxMycXFuENozNzt1TBoONE&language=fr&pagetoken=".$next_page_token;
                    
            $acurl = new acurl();
            $acurl->set_option('url',$url);
            $acurl->set_option('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:27.0) Gecko/20100101 Firefox/27.0');
            $answer = $acurl->http_request();
            $restaurants = json_decode($answer,true);
        
           echo PHP_EOL.'Page N° '.$page.' de résultat'.PHP_EOL; 
           if(count($restaurants["results"])>0){
                foreach($restaurants["results"] as $obj){
                    $this->getRestaurants($obj);
                }
            }else
                echo PHP_EOL.'Aucun Restaurant disponible dans cette localité '.PHP_EOL; 
            
            if(isset($restaurants["next_page_token"]) && !is_null($restaurants["next_page_token"])){
                $next_page_token = $restaurants["next_page_token"];
                $page ++;
            }else
                $next_page_token = null;
            
        }while (!is_null($next_page_token));

    }
    
    public function getRestaurants($rest){
        
        $restaurant = $this->rest_rep->findOneByGoogleId($rest["place_id"]);

        if(is_null($restaurant)){
            $restaurant = new Restaurant();
            $action = "récupéré";

            $restaurant->setAdresse($rest["vicinity"])
                       ->setLatitude($rest["geometry"]["location"]["lat"])
                       ->setLongitude($rest["geometry"]["location"]["lng"])
                       ->setGoogleId($rest["place_id"])
                       ->setNom($rest["name"]);

            if(isset($rest["rating"]) && !is_null($rest["rating"])){
                $restaurant->setGoogleRate($rest["rating"]);
            }
            
            if(isset($rest["photos"]) && !is_null($rest["photos"])){
                
                $i = 0;
                foreach($rest["photos"] as $p){
//                    $test = file_get_contents(str_replace("X_PHOTOREF_X",$p["photo_reference"] , $this->url_image));
//                    echo "<pre>";var_dump($test);"</pre>";
                    $photo = new Photo();
                    $url = Photo::downloadImage(str_replace("X_PHOTOREF_X",$p["photo_reference"] , $this->url_image),false,true);
                    $photo->setUrl($url)
                          ->setMiniature("thumbs/thumbs-".$url)
                          ->setTitre($rest["name"]." - Photo ".$i+1);
                    if($i==0){
                        $restaurant->setPhoto($url);
                    }
                    
                    $restaurant->addGallerie($photo);
                    $i++;
                }
            }


            $this->em->persist($restaurant);
            try{
                $this->em->flush();
                echo 'Restaurant "'.$restaurant->getNom().'" '.$action.PHP_EOL;
            } catch (Exception $e) {
                echo 'Exception reçue : ',  $e->getMessage(), "\n";
            }
            $restaurant->createThread();
            $this->em->persist($restaurant);
            try{
                $this->em->flush();
                echo 'Création des Thread du restaurant "'.$restaurant->getNom().'" effectué'.PHP_EOL.PHP_EOL;
            } catch (Exception $e) {
                echo 'Exception reçue : ',  $e->getMessage(), "\n";
            }
        }else
            echo PHP_EOL.'Restaurant déja récupéré'.PHP_EOL;            
                    
    }
    

        
        
}

?>
