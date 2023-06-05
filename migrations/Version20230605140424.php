<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605140424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autre_point_fonctionnement_rotor (id INT AUTO_INCREMENT NOT NULL, m DOUBLE PRECISION DEFAULT NULL, i_d DOUBLE PRECISION DEFAULT NULL, cd DOUBLE PRECISION DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE point_fonctionnement_rotor (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, INDEX IDX_D3B87FA66358FF62 (parametre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE point_fonctionnement_rotor ADD CONSTRAINT FK_D3B87FA66358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE parametre ADD autre_point_fonctionnement_rotor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790412788ADCC FOREIGN KEY (autre_point_fonctionnement_rotor_id) REFERENCES autre_point_fonctionnement_rotor (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790412788ADCC ON parametre (autre_point_fonctionnement_rotor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790412788ADCC');
        $this->addSql('ALTER TABLE point_fonctionnement_rotor DROP FOREIGN KEY FK_D3B87FA66358FF62');
        $this->addSql('DROP TABLE autre_point_fonctionnement_rotor');
        $this->addSql('DROP TABLE point_fonctionnement_rotor');
        $this->addSql('DROP INDEX UNIQ_ACC790412788ADCC ON parametre');
        $this->addSql('ALTER TABLE parametre DROP autre_point_fonctionnement_rotor_id');
    }
}
