<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605130712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autre_caracteristique (id INT AUTO_INCREMENT NOT NULL, etat TINYINT(1) DEFAULT NULL, resistance DOUBLE PRECISION NOT NULL, perte1 DOUBLE PRECISION NOT NULL, perte2 DOUBLE PRECISION NOT NULL, perte_fer1 DOUBLE PRECISION NOT NULL, perte_fer2 DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caracteristique (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, u DOUBLE PRECISION NOT NULL, i1 DOUBLE PRECISION NOT NULL, i2 DOUBLE PRECISION NOT NULL, i3 DOUBLE PRECISION NOT NULL, p DOUBLE PRECISION NOT NULL, q DOUBLE PRECISION NOT NULL, cos DOUBLE PRECISION NOT NULL, n DOUBLE PRECISION NOT NULL, pj DOUBLE PRECISION NOT NULL, p_pj DOUBLE PRECISION DEFAULT NULL, INDEX IDX_D14FBE8B6358FF62 (parametre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caracteristique ADD CONSTRAINT FK_D14FBE8B6358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE parametre ADD autre_caracteristique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC7904175562082 FOREIGN KEY (autre_caracteristique_id) REFERENCES autre_caracteristique (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC7904175562082 ON parametre (autre_caracteristique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC7904175562082');
        $this->addSql('ALTER TABLE caracteristique DROP FOREIGN KEY FK_D14FBE8B6358FF62');
        $this->addSql('DROP TABLE autre_caracteristique');
        $this->addSql('DROP TABLE caracteristique');
        $this->addSql('DROP INDEX UNIQ_ACC7904175562082 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP autre_caracteristique_id');
    }
}
