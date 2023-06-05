<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605114538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stator_apres_lavage (id INT AUTO_INCREMENT NOT NULL, temp_ambiante INT DEFAULT NULL, temp_tolerie INT DEFAULT NULL, hygrometrie DOUBLE PRECISION DEFAULT NULL, valeur1 DOUBLE PRECISION NOT NULL, valeur2 DOUBLE PRECISION NOT NULL, valeur3 DOUBLE PRECISION NOT NULL, valeur4 DOUBLE PRECISION NOT NULL, valeur5 DOUBLE PRECISION NOT NULL, valeur6 DOUBLE PRECISION NOT NULL, valeur7 DOUBLE PRECISION NOT NULL, conformite1 VARCHAR(255) NOT NULL, conformite2 VARCHAR(255) NOT NULL, conformite3 VARCHAR(255) NOT NULL, conformite4 VARCHAR(255) NOT NULL, conformite5 VARCHAR(255) NOT NULL, conformite6 VARCHAR(255) NOT NULL, conformite7 VARCHAR(255) NOT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD stator_apres_lavage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790417CC92E5D FOREIGN KEY (stator_apres_lavage_id) REFERENCES stator_apres_lavage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790417CC92E5D ON parametre (stator_apres_lavage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790417CC92E5D');
        $this->addSql('DROP TABLE stator_apres_lavage');
        $this->addSql('DROP INDEX UNIQ_ACC790417CC92E5D ON parametre');
        $this->addSql('ALTER TABLE parametre DROP stator_apres_lavage_id');
    }
}
