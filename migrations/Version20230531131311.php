<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531131311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE controle_geometrique (id INT AUTO_INCREMENT NOT NULL, pivot11 DOUBLE PRECISION DEFAULT NULL, pivot12 DOUBLE PRECISION DEFAULT NULL, pivot13 DOUBLE PRECISION DEFAULT NULL, pivot14 DOUBLE PRECISION DEFAULT NULL, pivot_e1 DOUBLE PRECISION DEFAULT NULL, pivot_e2 DOUBLE PRECISION DEFAULT NULL, pivot_e3 DOUBLE PRECISION DEFAULT NULL, pivot_e4 DOUBLE PRECISION DEFAULT NULL, pivot_f1 DOUBLE PRECISION DEFAULT NULL, pivot_f2 DOUBLE PRECISION DEFAULT NULL, pivot_f3 DOUBLE PRECISION DEFAULT NULL, pivot_f4 DOUBLE PRECISION DEFAULT NULL, conformite_b VARCHAR(255) DEFAULT NULL, conformite_e VARCHAR(255) DEFAULT NULL, conformite_f VARCHAR(255) DEFAULT NULL, add_1 DOUBLE PRECISION DEFAULT NULL, add_2 DOUBLE PRECISION DEFAULT NULL, add_3 DOUBLE PRECISION DEFAULT NULL, add_4 DOUBLE PRECISION DEFAULT NULL, conformite_add VARCHAR(255) DEFAULT NULL, tolerie_c1 DOUBLE PRECISION DEFAULT NULL, tolerie_c2 DOUBLE PRECISION DEFAULT NULL, tolerie_c3 DOUBLE PRECISION DEFAULT NULL, tolerie_c4 DOUBLE PRECISION DEFAULT NULL, conformite_c VARCHAR(255) DEFAULT NULL, tolerie_d1 DOUBLE PRECISION DEFAULT NULL, tolerie_d2 DOUBLE PRECISION DEFAULT NULL, tolerie_d3 DOUBLE PRECISION DEFAULT NULL, tolerie_d4 DOUBLE PRECISION DEFAULT NULL, conformite_d VARCHAR(255) DEFAULT NULL, accouplement_g1 DOUBLE PRECISION DEFAULT NULL, accouplement_g2 DOUBLE PRECISION DEFAULT NULL, accouplement_g3 DOUBLE PRECISION DEFAULT NULL, accouplement_g4 DOUBLE PRECISION DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD controle_geometrique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041FBF6FAEF FOREIGN KEY (controle_geometrique_id) REFERENCES controle_geometrique (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041FBF6FAEF ON parametre (controle_geometrique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041FBF6FAEF');
        $this->addSql('DROP TABLE controle_geometrique');
        $this->addSql('DROP INDEX UNIQ_ACC79041FBF6FAEF ON parametre');
        $this->addSql('ALTER TABLE parametre DROP controle_geometrique_id');
    }
}
