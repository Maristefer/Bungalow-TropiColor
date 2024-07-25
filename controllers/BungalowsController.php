<?php

class BungalowsController extends AbstractController
{
    
    public function listeBungalows(): void
    {
        $bm = new BungalowsManager();
        
        $bungalows = $bm->findAllBungalows();
        
        $this->render("bungalows/bungalows.html.twig",[
            "bungalows" =>$bungalows
            ]);
    }
    
   /* public function displayBungalow(int $id)
    {
        $bungalow = $this->bm->findBungalowById($id);
        
        if ($bungalow) {
            include 'bungalow_view.php';
        } else {
            echo "Bungalow non trouvé";
        }
    }*/
    
}
    
