<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627083322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, revue_enclenchement_id INT DEFAULT NULL, operations VARCHAR(255) NOT NULL, travaux VARCHAR(255) NOT NULL, heures DOUBLE PRECISION NOT NULL, INDEX IDX_E1BB182397C0E1CC (revue_enclenchement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudes_achats (id INT AUTO_INCREMENT NOT NULL, revue_enclenchement_id INT DEFAULT NULL, quoi VARCHAR(255) NOT NULL, delai DATE NOT NULL, observation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_A5C937D497C0E1CC (revue_enclenchement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE revue_enclenchement (id INT AUTO_INCREMENT NOT NULL, numero_contrat VARCHAR(255) NOT NULL, cahier_charge VARCHAR(255) NOT NULL, numero_pcq VARCHAR(255) NOT NULL, amiante VARCHAR(255) NOT NULL, contre_expertise VARCHAR(255) NOT NULL, re7_client DATE DEFAULT NULL, observation LONGTEXT DEFAULT NULL, delai_demande_client DATE NOT NULL, point_arret VARCHAR(255) NOT NULL, arrive_commande DATE NOT NULL, arc DATE NOT NULL, revue_enclenchement DATE NOT NULL, arrivee_machine DATE NOT NULL, objectif_rapport_expertise INT NOT NULL, objectif_mise_dispo INT NOT NULL, date_rapport_expertise_finalise DATE NOT NULL, date_machine_prete DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB182397C0E1CC FOREIGN KEY (revue_enclenchement_id) REFERENCES revue_enclenchement (id)');
        $this->addSql('ALTER TABLE etudes_achats ADD CONSTRAINT FK_A5C937D497C0E1CC FOREIGN KEY (revue_enclenchement_id) REFERENCES revue_enclenchement (id)');
        $this->addSql('ALTER TABLE affaire ADD revue_enclenchement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE affaire ADD CONSTRAINT FK_9C3F18EF97C0E1CC FOREIGN KEY (revue_enclenchement_id) REFERENCES revue_enclenchement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C3F18EF97C0E1CC ON affaire (revue_enclenchement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affaire DROP FOREIGN KEY FK_9C3F18EF97C0E1CC');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB182397C0E1CC');
        $this->addSql('ALTER TABLE etudes_achats DROP FOREIGN KEY FK_A5C937D497C0E1CC');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE etudes_achats');
        $this->addSql('DROP TABLE revue_enclenchement');
        $this->addSql('DROP INDEX UNIQ_9C3F18EF97C0E1CC ON affaire');
        $this->addSql('ALTER TABLE affaire DROP revue_enclenchement_id');
    }
}
