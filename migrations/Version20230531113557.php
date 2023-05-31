<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531113557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE controle_montage_conssinet (id INT AUTO_INCREMENT NOT NULL, accouplement_avant1 VARCHAR(255) DEFAULT NULL, accouplement_avant2 VARCHAR(255) DEFAULT NULL, accouplement_avant3 VARCHAR(255) DEFAULT NULL, accouplement_arriere1 VARCHAR(255) DEFAULT NULL, accouplement_arriere2 VARCHAR(255) DEFAULT NULL, accouplement_arriere3 VARCHAR(255) DEFAULT NULL, accouplement_oppose_avant1 VARCHAR(255) DEFAULT NULL, accouplement_oppose_avant2 VARCHAR(255) DEFAULT NULL, accouplement_oppose_avant3 VARCHAR(255) DEFAULT NULL, accouplement_oppose_arriere1 VARCHAR(255) DEFAULT NULL, accouplement_oppose_arriere2 VARCHAR(255) DEFAULT NULL, accouplement_oppose_arriere3 VARCHAR(255) DEFAULT NULL, ca_nature_releve VARCHAR(255) DEFAULT NULL, ca_diametre_attendu VARCHAR(255) DEFAULT NULL, ca_tolerence VARCHAR(255) DEFAULT NULL, ca_moyenne_releve VARCHAR(255) DEFAULT NULL, ca_conformite VARCHAR(255) DEFAULT NULL, ca_observation VARCHAR(255) DEFAULT NULL, coa_nature_releve VARCHAR(255) DEFAULT NULL, coa_diametre_attendu VARCHAR(255) DEFAULT NULL, coa_tolerance VARCHAR(255) DEFAULT NULL, coa_moyenne_releve VARCHAR(255) DEFAULT NULL, coa_conformite VARCHAR(255) DEFAULT NULL, coa_observation VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD controle_montage_coussinet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041A57C7608 FOREIGN KEY (controle_montage_coussinet_id) REFERENCES controle_montage_conssinet (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041A57C7608 ON parametre (controle_montage_coussinet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041A57C7608');
        $this->addSql('DROP TABLE controle_montage_conssinet');
        $this->addSql('DROP INDEX UNIQ_ACC79041A57C7608 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP controle_montage_coussinet_id');
    }
}
