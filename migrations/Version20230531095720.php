<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531095720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE controle_montage_roulement (id INT AUTO_INCREMENT NOT NULL, ca_roulement VARCHAR(255) DEFAULT NULL, ca_montage VARCHAR(255) DEFAULT NULL, ca_kit TINYINT(1) DEFAULT NULL, coa_roulement VARCHAR(255) DEFAULT NULL, coa_montage VARCHAR(255) DEFAULT NULL, coa_kit TINYINT(1) DEFAULT NULL, cote_ca_a VARCHAR(255) DEFAULT NULL, cote_ca_b VARCHAR(255) DEFAULT NULL, cote_ca_c VARCHAR(255) DEFAULT NULL, cote_ca_d VARCHAR(255) DEFAULT NULL, cote_ca_vide1 VARCHAR(255) DEFAULT NULL, cote_ca_jeu VARCHAR(255) DEFAULT NULL, cote_ca_vide2 VARCHAR(255) DEFAULT NULL, cote_coa_a VARCHAR(255) DEFAULT NULL, cote_coa_b VARCHAR(255) DEFAULT NULL, cote_coa_c VARCHAR(255) DEFAULT NULL, cote_coa_d VARCHAR(255) DEFAULT NULL, cote_coa_vide1 VARCHAR(255) DEFAULT NULL, cote_coa_jeu VARCHAR(255) DEFAULT NULL, cote_coa_vide2 VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD controle_montage_roulement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC7904112348756 FOREIGN KEY (controle_montage_roulement_id) REFERENCES controle_montage_roulement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC7904112348756 ON parametre (controle_montage_roulement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC7904112348756');
        $this->addSql('DROP TABLE controle_montage_roulement');
        $this->addSql('DROP INDEX UNIQ_ACC7904112348756 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP controle_montage_roulement_id');
    }
}
