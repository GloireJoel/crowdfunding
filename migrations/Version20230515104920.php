<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515104920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE financement (id INT AUTO_INCREMENT NOT NULL, montant DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet ADD financement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9A737ED74 FOREIGN KEY (financement_id) REFERENCES financement (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9A737ED74 ON projet (financement_id)');
        $this->addSql('ALTER TABLE user ADD financement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A737ED74 FOREIGN KEY (financement_id) REFERENCES financement (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A737ED74 ON user (financement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9A737ED74');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649A737ED74');
        $this->addSql('DROP TABLE financement');
        $this->addSql('DROP INDEX IDX_50159CA9A737ED74 ON projet');
        $this->addSql('ALTER TABLE projet DROP financement_id');
        $this->addSql('DROP INDEX IDX_8D93D649A737ED74 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP financement_id');
    }
}
