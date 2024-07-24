<?php

class DiscoveryController extends AbstractController
{
    public function discovery(): void
    {
        $this->render("",[]);
    }
    
    public function listePlages(): void
    {
        $pm = new PlagesManager();
        
        $plages = $am->findAllPlages();
        
        $this->render("",[]);
    }
}