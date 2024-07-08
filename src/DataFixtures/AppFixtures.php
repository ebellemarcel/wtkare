<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Propriete;
use App\Entity\Photo;
use App\Entity\Accessoire;
use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Créer des utilisateurs
        $user1 = new User();
        $user1->setEmail('jean.delarue@wtk.fr');
        $user1->setPrenom('Jean Pascal');
	$user1->setNom('De la Rue');
	$user1->setRoles(['ROLE_AGENT']);
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'password123'));
	$user1->setDateCreation(new \DateTime());
	$manager->persist($user1);
		
	$user3 = new User();
        $user3->setEmail('nicolas.royackkers@wtk.fr');
        $user3->setPrenom('Nicolas');
	$user3->setNom('Royackkers');
	$user3->setRoles(['ROLE_AGENT']);
        $user3->setPassword($this->passwordHasher->hashPassword($user3, 'P@$$w0rd+'));
	$user3->setDateCreation(new \DateTime());
	$manager->persist($user3);

        $user2 = new User();
        $user2->setEmail('admin@wtk.fr');
	$user2->setPrenom('Administrateur');
	$user2->setNom('WTK');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setPassword($this->passwordHasher->hashPassword($user2, '@dminpass123'));
	$user2->setDateCreation(new \DateTime());
	$manager->persist($user2);

        // Créer des caractéristiques
        $accessoires = [];
        $accessoireNames = ['Piscine', 'Jardin', 'Garage', 'Balcon', 'Vue mer', 'Cave', 'Parc'];
        foreach ($accessoireNames as $name) {
            $accessoire = new Accessoire();
            $accessoire->setNom($name);
	    $accessoire->setDescription($name);
	    $accessoire->setDateCreation(new \DateTime());
	    $accessoire->setDateUpdate(new \DateTime());
            $manager->persist($accessoire);
            $accessoires[] = $accessoire;
        }
		// Liste de rues, villes, departements à inserer dans les propriétés
						
			$rues = ['Rue de la Paix', 'Avenue des Champs-Élysées', 'Boulevard Haussmann', 'Rue du Faubourg Saint-Honoré', 'Rue de l espace', 'Rue de Rivoli', 'Boulevard Saint-Germain', 'Rue de Vaugirard', 'Avenue des Ternes', 'Rue de la Pompe'];
    
			$villes = ['Paris', 'Versailles', 'Saint-Denis', 'Boulogne-Billancourt', 'Nanterre', 'Créteil', 'Romainville', 'Évry', 'Melun', 'Bobigny'];
    
			$departements = ['75', '77', '78', '91', '92', '93', '94', '95'];
    

        // Créer des propriétés avec photos
        for ($i = 0; $i < 10; $i++) {
            $propriete = new Propriete();
            $propriete->setTitre("Propriété $i");
            $propriete->setDescription("Description de la propriété $i");
            $propriete->setType("Appartement");
            $propriete->setPrix(mt_rand(100000, 1000000));
	    $propriete->setSurface(mt_rand(35, 120));
	    $propriete->setChambres(mt_rand(1, 4));
		//// Bloc adresse
	    $numero = rand(1,150);
	    $rue = $rues[array_rand($rues)];
	    $ville = $villes[array_rand($villes)];
	    $departement = $departements[array_rand($departements)];
	    $codePostal = $departement . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
	    $propriete->setAdresse("$numero, $codePostal $ville");
	    $propriete->setVille($ville);
	    $propriete->setCodepostal($codePostal);
		
		//// Bloc latitude, longitude
	    $latMin = 48.1200;
	    $latMax = 49.2415;
	    $lonMin = 1.4461;
	    $lonMax = 3.5592;
			
	    $propriete->setLatitude(round($latMin + (mt_rand() / mt_getrandmax()) * ($latMax - $latMin),6));
	    $propriete->setLongitude(round($lonMin + (mt_rand() / mt_getrandmax()) * ($lonMax - $lonMin),6));
			
	    $propriete->setDateCreation(new \DateTime());
	    $propriete->setDateUpdate(new \DateTime());
			
            $propriete->setUserid($user1);

            // Ajouter des caractéristiques aléatoires
            $accessoirePropriete = array_rand($accessoires, mt_rand(4, 6));
            foreach ($accessoirePropriete as $index) {
                $propriete->addAccessoire($accessoires[$index]);
            }

            $manager->persist($propriete);

            // Ajouter des photos à la propriété
           $photosUrlarray = [
				'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg',
				'https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg',
				'https://images.unsplash.com/photo-1518780664697-55e3ad937233',
				'https://images.unsplash.com/photo-1564013799919-ab600027ffc6',
				'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
				'https://images.unsplash.com/photo-1568605114967-8130f3a36994',
				'https://images.pexels.com/photos/1029599/pexels-photo-1029599.jpeg',
				'https://images.unsplash.com/photo-1572120360610-d971b9d7767c',
				'https://images.pexels.com/photos/2587054/pexels-photo-2587054.jpeg',
				'https://images.unsplash.com/photo-1513584684374-8bab748fbf90',
				'https://images.pexels.com/photos/208736/pexels-photo-208736.jpeg',
				'https://images.unsplash.com/photo-1523217582562-09d0def993a6',
				'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg',
				'https://images.unsplash.com/photo-1512917774080-9991f1c4c750',
				'https://images.pexels.com/photos/1115804/pexels-photo-1115804.jpeg',
				'https://images.unsplash.com/photo-1570129477492-45c003edd2be',
				'https://images.pexels.com/photos/2581922/pexels-photo-2581922.jpeg',
				'https://images.unsplash.com/photo-1576941089067-2de3c901e126',
				'https://images.pexels.com/photos/2080018/pexels-photo-2080018.jpeg',
				'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83',
				'https://images.pexels.com/photos/1438832/pexels-photo-1438832.jpeg',
				'https://images.unsplash.com/photo-1604014237800-1c9102c219da',
				'https://images.pexels.com/photos/1642125/pexels-photo-1642125.jpeg',
				'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
				'https://images.pexels.com/photos/2102587/pexels-photo-2102587.jpeg',
				'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6',
				'https://images.pexels.com/photos/1732414/pexels-photo-1732414.jpeg',
				'https://images.unsplash.com/photo-1613977257363-707ba9348227',
				'https://images.pexels.com/photos/2079234/pexels-photo-2079234.jpeg',
				'https://images.unsplash.com/photo-1625602812206-5ec545ca1231',
				'https://images.pexels.com/photos/2089698/pexels-photo-2089698.jpeg',
				'https://images.unsplash.com/photo-1629236714692-fe2cd3861f61',
				'https://images.pexels.com/photos/2121121/pexels-photo-2121121.jpeg',
				'https://images.unsplash.com/photo-1633505899118-4ca4749f1f3c',
				'https://images.pexels.com/photos/2440471/pexels-photo-2440471.jpeg',
				'https://images.unsplash.com/photo-1636558837113-c7228395c4a3',
				'https://images.pexels.com/photos/2581922/pexels-photo-2581922.jpeg',
				'https://images.unsplash.com/photo-1639947641911-f5b089acad22',
				'https://images.pexels.com/photos/2724749/pexels-photo-2724749.jpeg',
				'https://images.unsplash.com/photo-1645327430174-6732ccee6f78',
				'https://images.pexels.com/photos/3288100/pexels-photo-3288100.png',
				'https://images.unsplash.com/photo-1650132801749-52b0cd69a08b',
				'https://images.pexels.com/photos/3288102/pexels-photo-3288102.png',
				'https://images.unsplash.com/photo-1653674698019-ed43f91d2bdf',
				'https://images.pexels.com/photos/3935320/pexels-photo-3935320.jpeg',
				'https://images.unsplash.com/photo-1658099843563-4af5d7c49192',
				'https://images.pexels.com/photos/4050318/pexels-photo-4050318.jpeg',
				'https://images.unsplash.com/photo-1661873742180-4f9b1cecbc64',
				'https://images.pexels.com/photos/4119832/pexels-photo-4119832.jpeg',
				'https://images.unsplash.com/photo-1665686308627-b08bd3b146b1'
			];

            $mainPhotoAdded = false;
            foreach (array_rand($photosUrlarray, mt_rand(5, 8)) as $index) {
                $photo = new Photo();
                $photo->setFilename($photosUrlarray[$index]);
		$photo->setDateCreation(new \DateTime());
		$photo->setPropriete($propriete);
		$photo->setPrincipale($index === 1);
                
                if (!$mainPhotoAdded) {
                    $photo->isPrincipale(true);
                    $mainPhotoAdded = true;
                } else {
                    $photo->isPrincipale(false);
                }

                $manager->persist($photo);
            }
			
			// Ajouter des demandes de contact pour la propriété
            $numberOfRequests = mt_rand(0, 3);  // 0 à 3 demandes par propriété
            for ($j = 0; $j < $numberOfRequests; $j++) {
                $contact = new Contact();
		$visit = mt_rand(1, 100);
                $contact->setNom("Visiteur " .$visit);
                $contact->setEmail("visiteur" . $visit . "@anynomous.com");
		$contact->setPhone("0011223344");
                $contact->setMessage("Je suis intéressé par la propriété $i. Pouvez-vous me donner plus d'informations ?");
                $contact->setPropriete($propriete);
                $contact->setDateCreation(new \DateTime());

                $manager->persist($contact);
            }
        }     

        $manager->flush();
    }
}
