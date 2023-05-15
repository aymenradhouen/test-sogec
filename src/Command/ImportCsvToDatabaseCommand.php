<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Entity\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-csv-to-database',
    description: 'Importer les données CSV vers la base de données',
)]
class ImportCsvToDatabaseCommand extends Command
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filepath', InputArgument::OPTIONAL, 'Path to file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filepath = $input->getArgument('filepath');

        //Verification du fichier si il est un CSV et si le fichier existe
        if ($filepath) {
            $ext = pathinfo($filepath, PATHINFO_EXTENSION);
            if(!file_exists($filepath)){
                $io->error('File not found !');
                return Command::FAILURE;
            } else if($ext != 'csv'){
                $io->error('Upload a valid CSV File !');
                return Command::FAILURE;
            }
            $rowNum = 0;
            if (($fp = fopen($filepath, "r")) !== FALSE) {
                while (($row = fgetcsv($fp, 1000, ",")) !== FALSE) {
                    $rowNum++;
                    //Verification de l'emplacement des colonnes du CSV pour que l'ordre des colonnes n'impacte pas l'import
                    if($rowNum == 1){
                        foreach ($row as $key => $data){
                            switch ($data){
                                case 'Name':
                                    $name = $key;
                                    break;
                                case 'Type 1':
                                    $type1 = $key;
                                    break;
                                case 'Type 2':
                                    $type2 = $key;
                                    break;
                                case 'Total':
                                    $total = $key;
                                    break;
                                case 'HP':
                                    $hp = $key;
                                    break;
                                case 'Attack':
                                    $attack = $key;
                                    break;
                                case 'Defense':
                                    $defense = $key;
                                    break;
                                case 'Sp. Atk':
                                    $spAtk = $key;
                                    break;
                                case 'Sp. Def':
                                    $spDef = $key;
                                    break;
                                case 'Speed':
                                    $speed = $key;
                                    break;
                                case 'Generation':
                                    $generation = $key;
                                    break;
                                case 'Legendary':
                                    $legendary = $key;
                                    break;
                            }
                        }
                        continue;
                    }
                    //Verification du type si il existe sinon on fait sa creation
                    $type = $this->em->getRepository(\App\Entity\Type::class)->findOneBy([
                        'type1' => $row[$type1],
                        'type2' => $row[$type2]
                    ]);
                    if(!$type){
                        $type = new \App\Entity\Type($row[$type1],$row[$type2]);
                        $this->em->getRepository(\App\Entity\Type::class)->add($type);
                    }
                    //Verification des statistiques si ils existent sinon on fait leur creations

                    $statistique = $this->em->getRepository(Statistique::class)->findOneBy([
                        'total' =>  $row[$total],
                        'hp' => $row[$hp],
                        'attack' => $row[$attack],
                        'defense' => $row[$defense],
                        'spAtk' => $row[$spAtk],
                        'spDef' => $row[$spDef],
                        'speed' => $row[$speed]
                    ]);
                    if(!$statistique){
                        $statistique = new Statistique(
                            $row[$total],
                            $row[$hp],
                            $row[$attack],
                            $row[$defense],
                            $row[$spAtk],
                            $row[$spDef],
                            $row[$speed]
                        );
                        $this->em->getRepository(Statistique::class)->add($statistique);
                    }

                    //Verification du pokemon si il existe sinon on fait sa creation
                    $pokemon = $this->em->getRepository(Pokemon::class)->findOneBy([
                        'name' => $row[$name],
                        'type' => $type,
                        'statistique' => $statistique,
                        'generation' => $row[$generation],
                        'legendary' => !($row[$legendary] == 'False')
                    ]);
                    if(!$pokemon){
                        $pokemon = new Pokemon(
                            $row[$name],
                            $type,
                            $statistique,
                            $row[$generation],
                            !($row[$legendary] == 'False')
                        );
                    }
                    $this->em->getRepository(Pokemon::class)->add($pokemon);
                }
                fclose($fp);
            }
        } else {
            $io->error('No file path specified !');
            return Command::FAILURE;
        }


        $io->success('Your CSV is imported successfully.');

        return Command::SUCCESS;
    }
}
