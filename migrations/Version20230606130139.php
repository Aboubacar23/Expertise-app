<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606130139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE remontage_equilibrage (id INT AUTO_INCREMENT NOT NULL, vitesse DOUBLE PRECISION DEFAULT NULL, poids_rotor DOUBLE PRECISION DEFAULT NULL, vitesse_equilibrage DOUBLE PRECISION DEFAULT NULL, nb_plan DOUBLE PRECISION DEFAULT NULL, qualite_equilibrage VARCHAR(255) DEFAULT NULL, clavette_entiere TINYINT(1) DEFAULT NULL, clavette_1_2 TINYINT(1) DEFAULT NULL, clavette_sans TINYINT(1) DEFAULT NULL, sans_plan_ca1 DOUBLE PRECISION DEFAULT NULL, sans_plan_ca2 DOUBLE PRECISION DEFAULT NULL, sans_plan_ca3 DOUBLE PRECISION DEFAULT NULL, sans_plan_ca4 DOUBLE PRECISION DEFAULT NULL, sans_plan_ca5 DOUBLE PRECISION DEFAULT NULL, sans_plan_ca6 DOUBLE PRECISION DEFAULT NULL, avec_plan_ca1 DOUBLE PRECISION DEFAULT NULL, avec_plan_ca2 DOUBLE PRECISION DEFAULT NULL, avec_plan_ca3 DOUBLE PRECISION DEFAULT NULL, avec_plan_ca4 DOUBLE PRECISION DEFAULT NULL, avec_plan_ca5 DOUBLE PRECISION DEFAULT NULL, avec_plan_ca6 DOUBLE PRECISION DEFAULT NULL, correction VARCHAR(255) DEFAULT NULL, sans_plan_coa1 DOUBLE PRECISION DEFAULT NULL, sans_plan_coa2 DOUBLE PRECISION DEFAULT NULL, sans_plan_coa3 DOUBLE PRECISION DEFAULT NULL, sans_plan_coa4 DOUBLE PRECISION DEFAULT NULL, sans_plan_coa5 DOUBLE PRECISION DEFAULT NULL, sans_plan_coa6 DOUBLE PRECISION DEFAULT NULL, avec_plan_coa1 DOUBLE PRECISION DEFAULT NULL, avec_plan_coa2 DOUBLE PRECISION DEFAULT NULL, avec_plan_coa3 DOUBLE PRECISION DEFAULT NULL, avec_plan_coa4 DOUBLE PRECISION DEFAULT NULL, avec_plan_coa5 DOUBLE PRECISION DEFAULT NULL, avec_plan_coa6 DOUBLE PRECISION DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD remontage_equilibrage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041EC0D52FD FOREIGN KEY (remontage_equilibrage_id) REFERENCES remontage_equilibrage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041EC0D52FD ON parametre (remontage_equilibrage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041EC0D52FD');
        $this->addSql('DROP TABLE remontage_equilibrage');
        $this->addSql('DROP INDEX UNIQ_ACC79041EC0D52FD ON parametre');
        $this->addSql('ALTER TABLE parametre DROP remontage_equilibrage_id');
    }
}
