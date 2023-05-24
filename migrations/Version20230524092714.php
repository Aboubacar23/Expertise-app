<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524092714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autre_controle (id INT AUTO_INCREMENT NOT NULL, balais_preconisation1 VARCHAR(255) DEFAULT NULL, balais_preconisation2 VARCHAR(255) DEFAULT NULL, balais_preconisation3 VARCHAR(255) DEFAULT NULL, balais_preconisation4 VARCHAR(255) DEFAULT NULL, balais_preconisation5 VARCHAR(255) DEFAULT NULL, balais_preconisation6 VARCHAR(255) DEFAULT NULL, balais_masse_preconisation1 VARCHAR(255) DEFAULT NULL, balais__masse_preconisation2 VARCHAR(255) DEFAULT NULL, balais__masse_preconisation3 VARCHAR(255) DEFAULT NULL, balais__masse_preconisation4 VARCHAR(255) DEFAULT NULL, balais__masse_preconisation5 VARCHAR(255) DEFAULT NULL, balais__masse_preconisation6 VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, balais_conformite1 VARCHAR(255) DEFAULT NULL, balais_conformite2 VARCHAR(255) DEFAULT NULL, balais_conformite3 VARCHAR(255) DEFAULT NULL, balais_conformite4 VARCHAR(255) DEFAULT NULL, balais_conformite5 VARCHAR(255) DEFAULT NULL, balais_conformite6 VARCHAR(255) DEFAULT NULL, balais_masse_conformite1 VARCHAR(255) DEFAULT NULL, balais_masse_conformite2 VARCHAR(255) DEFAULT NULL, balais_masse_conformite3 VARCHAR(255) DEFAULT NULL, balais_masse_conformite4 VARCHAR(255) DEFAULT NULL, balais_masse_conformite5 VARCHAR(255) DEFAULT NULL, balais_masse_conformite6 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD autre_controle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790415C8FF0A2 FOREIGN KEY (autre_controle_id) REFERENCES autre_controle (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790415C8FF0A2 ON parametre (autre_controle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790415C8FF0A2');
        $this->addSql('DROP TABLE autre_controle');
        $this->addSql('DROP INDEX UNIQ_ACC790415C8FF0A2 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP autre_controle_id');
    }
}
