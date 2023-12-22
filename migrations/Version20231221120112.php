<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221120112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video_watch (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, video_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_DF694384A76ED395 (user_id), INDEX IDX_DF69438429C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video_watch ADD CONSTRAINT FK_DF694384A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video_watch ADD CONSTRAINT FK_DF69438429C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video_watch DROP FOREIGN KEY FK_DF694384A76ED395');
        $this->addSql('ALTER TABLE video_watch DROP FOREIGN KEY FK_DF69438429C1004E');
        $this->addSql('DROP TABLE video_watch');
    }
}
