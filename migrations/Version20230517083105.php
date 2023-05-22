<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517083105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, machine_id INT DEFAULT NULL, type_id INT DEFAULT NULL, affaire_id INT DEFAULT NULL, type_machine VARCHAR(255) NOT NULL, puissance DOUBLE PRECISION NOT NULL, montage VARCHAR(255) NOT NULL, fabricant VARCHAR(255) NOT NULL, presence_balais TINYINT(1) NOT NULL, vitesse DOUBLE PRECISION NOT NULL, masse DOUBLE PRECISION NOT NULL, type_palier VARCHAR(255) NOT NULL, presence_balais_masse TINYINT(1) NOT NULL, stator_tension DOUBLE PRECISION NOT NULL, stator_frequence DOUBLE PRECISION NOT NULL, stator_courant DOUBLE PRECISION DEFAULT NULL, stator_couplage VARCHAR(255) DEFAULT NULL, date_arrivee DATE DEFAULT NULL, rotor_tension DOUBLE PRECISION DEFAULT NULL, rotor_expertise_refrigeant VARCHAR(255) DEFAULT NULL, rotor_courant DOUBLE PRECISION DEFAULT NULL, presence_plans TINYINT(1) DEFAULT NULL, INDEX IDX_ACC79041F6B75B26 (machine_id), INDEX IDX_ACC79041C54C8C93 (type_id), INDEX IDX_ACC79041F082E755 (affaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041F082E755 FOREIGN KEY (affaire_id) REFERENCES affaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041F6B75B26');
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041C54C8C93');
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041F082E755');
        $this->addSql('DROP TABLE parametre');
    }
}
