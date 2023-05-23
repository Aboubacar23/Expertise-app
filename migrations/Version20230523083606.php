<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523083606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE controle_visuel_electrique (id INT AUTO_INCREMENT NOT NULL, balais_dimension VARCHAR(255) DEFAULT NULL, balais_marque VARCHAR(255) DEFAULT NULL, balais_quantite INT DEFAULT NULL, balais_nuance VARCHAR(255) DEFAULT NULL, balais_longuer_shunt INT DEFAULT NULL, balais_type_cosse VARCHAR(255) DEFAULT NULL, balais_aspect VARCHAR(255) DEFAULT NULL, balais_type_pression VARCHAR(255) DEFAULT NULL, balais_presence_gaine TINYINT(1) DEFAULT NULL, balais_masse_dimension VARCHAR(255) DEFAULT NULL, balais_masse_marque VARCHAR(255) DEFAULT NULL, balais_masse_quantite INT DEFAULT NULL, balais_masse_nuance VARCHAR(255) DEFAULT NULL, balais_masse_longuer_shunt INT DEFAULT NULL, balais_masse_type_cosse VARCHAR(255) DEFAULT NULL, balais_masse_aspect VARCHAR(255) DEFAULT NULL, balais_masse_type_pression VARCHAR(255) DEFAULT NULL, balais_masse_gaine TINYINT(1) DEFAULT NULL, sens_rotation VARCHAR(255) DEFAULT NULL, remarque VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE controle_visuel_electrique');
    }
}
