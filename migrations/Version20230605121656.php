<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605121656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sonde_bobinage (id INT AUTO_INCREMENT NOT NULL, temp_ambiante INT NOT NULL, temp_tolerie INT NOT NULL, hygrometrie DOUBLE PRECISION NOT NULL, valeur1 DOUBLE PRECISION NOT NULL, valeur2 DOUBLE PRECISION NOT NULL, valeur3 DOUBLE PRECISION NOT NULL, valeur4 DOUBLE PRECISION NOT NULL, conformite1 VARCHAR(255) NOT NULL, conformite2 VARCHAR(255) NOT NULL, conformite3 VARCHAR(255) NOT NULL, conformite4 VARCHAR(255) NOT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD sonde_bobinage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790411DCB46DC FOREIGN KEY (sonde_bobinage_id) REFERENCES sonde_bobinage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790411DCB46DC ON parametre (sonde_bobinage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790411DCB46DC');
        $this->addSql('DROP TABLE sonde_bobinage');
        $this->addSql('DROP INDEX UNIQ_ACC790411DCB46DC ON parametre');
        $this->addSql('ALTER TABLE parametre DROP sonde_bobinage_id');
    }
}
