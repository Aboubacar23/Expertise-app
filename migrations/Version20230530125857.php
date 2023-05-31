<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530125857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessoire_supplementaire (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controle_visuel_mecanique (id INT AUTO_INCREMENT NOT NULL, bridage TINYINT(1) NOT NULL, chassis TINYINT(1) DEFAULT NULL, boite_borne TINYINT(1) DEFAULT NULL, barrette_neutre TINYINT(1) DEFAULT NULL, reference_rotor VARCHAR(255) DEFAULT NULL, reference_stator VARCHAR(255) DEFAULT NULL, peinture VARCHAR(255) DEFAULT NULL, vis_verins TINYINT(1) DEFAULT NULL, tresse_masse TINYINT(1) DEFAULT NULL, clavette TINYINT(1) DEFAULT NULL, sonde_palier_ca VARCHAR(255) DEFAULT NULL, sonde_palier_coa VARCHAR(255) DEFAULT NULL, autres_sondes VARCHAR(255) DEFAULT NULL, numero_serie VARCHAR(255) DEFAULT NULL, nombre_accessoire INT DEFAULT NULL, accouplement VARCHAR(255) DEFAULT NULL, position_accouplement VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD controle_visuel_mecanique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC7904179226542 FOREIGN KEY (controle_visuel_mecanique_id) REFERENCES controle_visuel_mecanique (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC7904179226542 ON parametre (controle_visuel_mecanique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC7904179226542');
        $this->addSql('DROP TABLE accessoire_supplementaire');
        $this->addSql('DROP TABLE controle_visuel_mecanique');
        $this->addSql('DROP INDEX UNIQ_ACC7904179226542 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP controle_visuel_mecanique_id');
    }
}
