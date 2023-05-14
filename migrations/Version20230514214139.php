<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514214139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, statistique_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, generation INT NOT NULL, legendary TINYINT(1) NOT NULL, INDEX IDX_62DC90F3C54C8C93 (type_id), INDEX IDX_62DC90F376A81463 (statistique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistique (id INT AUTO_INCREMENT NOT NULL, total INT DEFAULT NULL, hp INT NOT NULL, attack INT NOT NULL, defense INT NOT NULL, sp_atk INT NOT NULL, sp_def VARCHAR(50) NOT NULL, speed INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type1 VARCHAR(15) NOT NULL, type2 VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F376A81463 FOREIGN KEY (statistique_id) REFERENCES statistique (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3C54C8C93');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F376A81463');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE statistique');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
